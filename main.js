const {app, BrowserWindow} = require('electron')
var port = 8042;
var path = require("path");
var os = require("os");
connect = require("gulp-connect-php");

// on utilise les fichiers binaires php uniquement sur Windows
if(os.platform() === 'win32') {
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
	width: 800,
	height: 600,
	backgroundColor: "#66CD00",
	webPreferences: {
	    nodeIntegration: false,
	    "page-visibility": true
	}
    })

    win.loadURL('http://127.0.0.1:8042/dashboard')


    win.on('closed', () => {
	win = null
    })
}

app.on('ready', createWindow)

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
