const {app, BrowserWindow, Menu, Tray} = require('electron')
const port = 8042;
const path = require("path");
const connect = require("gulp-connect-php");

// on utilise les fichiers binaires php uniquement sur Windows
if(process.platform === 'win32') {
    var con = connect.server({
        port: port,
        hostname: "127.0.0.1",
        base: path.resolve(__dirname) + '/src/public',
        keepalive: true,
        open: false,
        bin: path.resolve(__dirname)+"/bin/php",
        root: "/",
        stdio: "inherit"
    });
} else {
    var con = connect.server({
        port: port,
        hostname: "127.0.0.1",
        base: path.resolve(__dirname) + '/src/public',
        keepalive: true,
        open: false,
        // bin n'apparait pas sur Linux et Mac
        root: "/",
        stdio: "inherit"
    });
}
let win

function createWindow () {
    win = new BrowserWindow( {
        show: false,
        width: 800,
        height: 600,
        webPreferences: {
            nodeIntegration: true,
        }
    })

    //win.setMenu(null) <- A DE-COMMENTER EN PRODUCTION
    win.loadURL('http://127.0.0.1:8042/dashboard')

    win.once('ready-to-show', () => {
        win.show()
    })

    win.on('closed', () => {
        win = null
    })
}

app.on('ready', createWindow)

let tray = null
app.on('ready', () => {
    win.webContents.on('notify', function() {
        win.webContents.executeJavaScript("alert('Hello There!');");
    });

    tray = new Tray('./icon.png')
    const contextMenu = Menu.buildFromTemplate([
        { label: 'Afficher', click:  function(){
            win.show();
        } },
        { label: 'Fermer', click:  function(){
            app.isQuiting = true;
            app.quit();
        } }
    ]);
    tray.setToolTip('This is my application.')
    tray.setContextMenu(contextMenu)
})

app.on('minimize',function(event){
    event.preventDefault()
    win.hide();
});

app.on('close', function (event) {
    if( !application.isQuiting){
        event.preventDefault()
        win.hide();
    }
    return false;
});

app.on('window-all-closed', () => {
    if (process.platform !== 'darwin') {
        app.quit()
    }
})

app.on('activate', () => {
    if (win === null) {
        createWindow()
    }
})
