"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.deactivate = exports.activate = void 0;
const vscode = require("vscode");
const path = require("path");
const fs = require("fs");
const which = require("which");
const child_process_1 = require("child_process");
const minimatch_1 = require("minimatch");
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type
function activate(context) {
    const configFiles = [
        '.prettyphp',
        'prettyphp.json'
    ];
    const disableMaps = [
        { config: 'formatting.declarationSpacing', arg: 'declaration-spacing' },
        { config: 'formatting.moveComments', arg: 'move-comments' },
        { config: 'formatting.simplifyStrings', arg: 'simplify-strings' },
        { config: 'formatting.simplifyNumbers', arg: 'simplify-numbers' }
    ];
    const enableMaps = [
        { config: 'formatting.blankBeforeReturn', arg: 'blank-before-return' },
        { config: 'formatting.strictLists', arg: 'strict-lists' },
        { config: 'formatting.alignment.alignData', arg: 'align-data' },
        { config: 'formatting.alignment.alignChains', arg: 'align-chains' },
        { config: 'formatting.alignment.alignComments', arg: 'align-comments' },
        { config: 'formatting.alignment.alignFn', arg: 'align-fn' },
        { config: 'formatting.alignment.alignLists', arg: 'align-lists' },
        { config: 'formatting.alignment.alignTernaryOperators', arg: 'align-ternary' },
        { config: 'formatting.preserveOneLineStatements', arg: 'preserve-one-line' }
    ];
    function migrateConfiguration(from, to, valueCallback) {
        const config = vscode.workspace.getConfiguration('pretty-php');
        const currentFrom = config.inspect(from);
        const currentTo = config.inspect(to);
        maybeUpdateConfiguration(config, from, to, currentFrom?.globalValue, currentTo?.globalValue, valueCallback, true);
        maybeUpdateConfiguration(config, from, to, currentFrom?.workspaceValue, currentTo?.workspaceValue, valueCallback, false);
    }
    function maybeUpdateConfiguration(config, from, to, fromValue, toValue, valueCallback, global) {
        // Old setting not set?
        if (fromValue == null) {
            return;
        }
        if (valueCallback != null) {
            // Replace old value with equivalent new value
            fromValue = valueCallback(fromValue);
            // Remove old setting if old value is equivalent to being unset
            if (fromValue == null) {
                void config.update(from, undefined, global);
                return;
            }
        }
        // New setting already set?
        if (toValue != null) {
            // Remove old setting if values match, otherwise leave for manual removal
            if (fromValue === toValue) {
                void config.update(from, undefined, global);
            }
            return;
        }
        void config.update(to, fromValue, global)
            .then(() => { void config.update(from, undefined, global); });
    }
    function formatDocument(document, insertSpaces, tabSize, ...prettyPhpArgs) {
        return new Promise(resolve => {
            const args = getCommand(document, insertSpaces, tabSize);
            const command = args?.shift();
            if (args === undefined || command === undefined) {
                resolve([]);
                return;
            }
            args.push(...prettyPhpArgs);
            const text = document.getText();
            const php = (0, child_process_1.spawn)(command, [
                ...args,
                '-q',
                '--',
                '-' // Specify that code to format should be taken from the standard input
            ]);
            log.info('Spawned:', ...php.spawnargs);
            let stdout = '';
            php.stdout.setEncoding('utf8');
            php.stdout.on('data', (chunk) => { stdout += chunk; });
            let stderr = '';
            php.stderr.setEncoding('utf8');
            php.stderr.on('data', (chunk) => { stderr += chunk; });
            php.on('close', (code, signal) => {
                if (stderr.length > 0) {
                    log.info(`${php.spawnfile} reported:\n${stderr}`);
                }
                if (code === 0) {
                    log.info(`${php.spawnfile} succeeded (output length: ${stdout.length})`);
                    if (stdout.length > 0 && stdout !== text) {
                        resolve([
                            new vscode.TextEdit(new vscode.Range(document.lineAt(0).range.start, document.lineAt(document.lineCount - 1).rangeIncludingLineBreak.end), stdout)
                        ]);
                    }
                    else {
                        log.info('Nothing to change');
                        resolve([]);
                    }
                }
                else if (code === 2) {
                    log.error(`${php.spawnfile} found invalid configuration files (exit status: ${code})`);
                    showErrorMessage('pretty-php found invalid configuration files: ' + stderr);
                    resolve([]);
                }
                else if (code === 4) {
                    log.info(`${php.spawnfile} reported invalid input (exit status: ${code})`);
                    resolve([]);
                }
                else {
                    if (signal === null) {
                        log.error(`${php.spawnfile} failed with exit status ${code ?? '<unknown>'}`);
                    }
                    else {
                        log.error(`${php.spawnfile} terminated by signal ${signal}`);
                    }
                    showErrorMessage('pretty-php failed: ' + stderr);
                    resolve([]);
                }
            });
            php.stdin.write(text);
            php.stdin.end();
        });
    }
    function getCommand(document, insertSpaces, tabSize) {
        const php = getPath('PHP', 'phpPath', 'php', true);
        if (php === undefined) {
            return;
        }
        const formatter = getPath('formatter', 'formatterPath', path.resolve(__dirname, '../bin/pretty-php.phar'), false);
        if (formatter === undefined) {
            return;
        }
        const prettyPhpArgs = [
            php,
            '-ddisplay_errors=stderr',
            '-dshort_open_tag=On',
            formatter
        ];
        const config = vscode.workspace.getConfiguration('pretty-php');
        const formatterArguments = config.get('formatterArguments');
        if (formatterArguments != null) {
            prettyPhpArgs.push(...formatterArguments);
        }
        disableMaps.forEach((map) => {
            const enabled = config.get(map.config);
            if (enabled == null || !enabled) {
                prettyPhpArgs.push('-i', map.arg);
            }
        });
        enableMaps.forEach((map) => {
            const enabled = config.get(map.config);
            if (enabled != null && enabled) {
                prettyPhpArgs.push('-r', map.arg);
            }
        });
        maybeAddArgs(prettyPhpArgs, 'formatting.heredocIndentation', '-h');
        const operatorPlacement = config.get('formatting.operatorPlacement');
        if (operatorPlacement === 'first') {
            prettyPhpArgs.push('-O');
        }
        else if (operatorPlacement === 'last') {
            prettyPhpArgs.push('-L');
        }
        const tightDeclarationSpacing = config.get('formatting.tightDeclarationSpacing');
        if (tightDeclarationSpacing != null && tightDeclarationSpacing) {
            prettyPhpArgs.push('-T');
        }
        const sortImportsBy = config.get('formatting.sortImportsBy');
        if (sortImportsBy === 'off') {
            prettyPhpArgs.push('-M');
        }
        else {
            maybeAddArgs(prettyPhpArgs, 'formatting.sortImportsBy', '-m');
        }
        const psr12 = config.get('formatting.psr12');
        if (psr12 != null && psr12) {
            prettyPhpArgs.push('--psr12');
        }
        if (document !== undefined) {
            const filename = document.uri.scheme === 'file' ? document.uri.fsPath : null;
            if (filename !== null) {
                prettyPhpArgs.push('-F', filename);
            }
        }
        if (insertSpaces !== undefined && tabSize !== undefined) {
            // Pass the editor's indent type and size to pretty-php
            prettyPhpArgs.push((insertSpaces ? '-s' : '-t') + String(normaliseTabSize(tabSize)));
        }
        return prettyPhpArgs;
    }
    function maybeAddArgs(args, setting, option) {
        const config = vscode.workspace.getConfiguration('pretty-php');
        const value = config.get(setting);
        if (value != null && value !== config.inspect(setting)?.defaultValue) {
            args.push(option, value);
        }
    }
    function getPath(name, setting, defaultPath, executable) {
        const settingPath = vscode.workspace.getConfiguration('pretty-php').get(setting);
        const file = settingPath != null && settingPath !== '' ? settingPath : defaultPath;
        if (path.isAbsolute(file)) {
            try {
                fs.accessSync(file, fs.constants.R_OK | (executable ? fs.constants.X_OK : 0));
                return file;
            }
            catch { }
        }
        else {
            const pathPath = which.sync(file, { nothrow: true });
            if (pathPath !== null) {
                return pathPath;
            }
        }
        setting = 'pretty-php.' + setting;
        showErrorMessage(`'${file}' not found. Use the '${setting}' setting to configure the ${name} path.`, setting);
    }
    function showErrorMessage(message, setting) {
        if (setting === undefined) {
            void vscode.window.showErrorMessage(message);
        }
        else {
            const goToSetting = 'Go to setting';
            void vscode.window.showErrorMessage(message, goToSetting)
                .then(item => {
                if (item === goToSetting) {
                    void vscode.commands.executeCommand('workbench.action.openSettings', setting);
                }
            });
        }
    }
    function normaliseTabSize(tabSize) {
        return tabSize > 4
            ? 8
            : (tabSize > 2
                ? 4
                : 2);
    }
    function handleCommand(...prettyPhpArgs) {
        const document = vscode.window.activeTextEditor?.document;
        if (document != null) {
            const options = vscode.window.activeTextEditor?.options;
            const insertSpaces = typeof options?.insertSpaces === 'boolean' ? options.insertSpaces : true;
            const tabSize = typeof options?.tabSize === 'number' ? options.tabSize : 4;
            formatDocument(document, insertSpaces, tabSize, ...prettyPhpArgs)
                .then((edits) => {
                const edit = new vscode.WorkspaceEdit();
                edit.set(document.uri, edits);
                vscode.workspace.applyEdit(edit)
                    .then(() => { }, () => { });
            }, () => { });
        }
    }
    async function createConfigFile(resource, selection) {
        let folder;
        if (resource === undefined) {
            if (vscode.workspace.workspaceFolders === undefined ||
                vscode.workspace.workspaceFolders[0] === undefined) {
                showErrorMessage('There are no folders in the current workspace.');
                return;
            }
            folder = vscode.workspace.workspaceFolders[0];
        }
        else {
            const workspaceFolder = vscode.workspace.getWorkspaceFolder(resource);
            if (workspaceFolder === undefined) {
                showErrorMessage(`'${resource.toString()}' does not belong to a workspace.`);
                return;
            }
            folder = workspaceFolder;
        }
        function addSource(uri) {
            const relative = vscode.workspace.asRelativePath(uri, false);
            src.push(relative === folder.uri.fsPath ? '.' : relative);
        }
        const src = [];
        if (selection !== undefined && selection.length > 1) {
            for (const selectionUri of selection) {
                const selectionFolder = vscode.workspace.getWorkspaceFolder(selectionUri);
                if (selectionFolder === undefined || selectionFolder.index !== folder.index) {
                    showErrorMessage('Selected files do not belong to the same workspace.');
                    return;
                }
                addSource(selectionUri);
            }
        }
        else {
            addSource(folder.uri);
        }
        const notFound = [];
        const found = [];
        for (const configFile of configFiles) {
            const configUri = vscode.Uri.joinPath(folder.uri, configFile);
            try {
                await vscode.workspace.fs.stat(configUri);
                found.push(configUri);
            }
            catch (ex) {
                if (ex instanceof vscode.FileSystemError &&
                    ex.code === 'FileNotFound') {
                    notFound.push(configUri);
                    continue;
                }
                throw ex;
            }
        }
        if (found.length > 1) {
            showErrorMessage(`Invalid configuration. Delete one of these and try again: ${found.map((uri) => uri.fsPath).join(' ')}`);
            return;
        }
        let configUri;
        if (found.length === 1) {
            const response = await vscode.window.showInformationMessage(`'${found[0].fsPath}' already exists. Replace it?`, 'Replace', 'Cancel');
            if (response !== 'Replace') {
                return;
            }
            configUri = found[0];
        }
        else {
            const configFile = await vscode.window.showQuickPick(configFiles, { title: 'Which would you like to create?' });
            if (configFile === undefined) {
                return;
            }
            configUri = vscode.Uri.joinPath(folder.uri, configFile);
        }
        const args = getCommand();
        const command = args?.shift();
        if (args === undefined || command === undefined) {
            return;
        }
        args.push('--print-config', '--', ...src);
        const options = {
            encoding: 'utf8',
            cwd: folder.uri.fsPath
        };
        log.info('Spawning:', command, ...args);
        const result = (0, child_process_1.spawnSync)(command, args, options);
        if (result.stderr.length > 0) {
            log.info(`${command} reported:\n${result.stderr}`);
        }
        if (result.status !== 0) {
            if (result.signal === null) {
                log.error(`${command} failed with exit status ${result.status ?? '<unknown>'}`);
            }
            else {
                log.error(`${command} terminated by signal ${result.signal}`);
            }
            showErrorMessage('pretty-php failed: ' + result.stderr);
            return;
        }
        log.info(`${command} succeeded (output length: ${result.stdout.length})`);
        log.info(`Creating ${configUri.toString()}`);
        await vscode.workspace.fs.writeFile(configUri, (new TextEncoder()).encode(result.stdout));
        void vscode.window.showInformationMessage(`'${configUri.fsPath}' created successfully.`);
    }
    const log = vscode.window.createOutputChannel('pretty-php', { log: true });
    migrateConfiguration('formatting.blankBeforeDeclaration', 'formatting.declarationSpacing');
    migrateConfiguration('formatting.alignment.alignAssignments', 'formatting.alignment.alignData');
    migrateConfiguration('formatting.indentHeredocs', 'formatting.heredocIndentation', function (value) {
        switch (value) {
            case true:
                return undefined;
            case false:
                return 'none';
        }
    });
    migrateConfiguration('formatting.sortImports', 'formatting.sortImportsBy', function (value) {
        switch (value) {
            case true:
                return undefined;
            case false:
                return 'off';
        }
    });
    vscode.languages.registerDocumentFormattingEditProvider('php', {
        provideDocumentFormattingEdits(document, options) {
            if (document.uri.scheme === 'file') {
                const exclude = vscode.workspace.getConfiguration('pretty-php').get('files.exclude');
                if (exclude !== undefined && exclude.length > 0) {
                    const filename = document.uri.toString();
                    for (const pattern of exclude) {
                        if ((0, minimatch_1.minimatch)(filename, pattern)) {
                            log.info(`${filename} excluded by pretty-php.files.exclude pattern: ${pattern}`);
                            return Promise.resolve([]);
                        }
                    }
                }
            }
            return formatDocument(document, options.insertSpaces, options.tabSize);
        }
    });
    context.subscriptions.push(vscode.commands.registerCommand('pretty-php.format', () => handleCommand()), vscode.commands.registerCommand('pretty-php.formatWithoutNewlines', () => handleCommand('-N')), vscode.commands.registerCommand('pretty-php.createConfigFile', createConfigFile));
}
exports.activate = activate;
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type
function deactivate() { }
exports.deactivate = deactivate;
//# sourceMappingURL=extension.js.map