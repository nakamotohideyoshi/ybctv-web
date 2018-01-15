var fs = require('fs');
let Client = require('ssh2-sftp-client');
let sftp = new Client();
 
fs.readFile('credentials.txt', 'utf8', function(err, contents) {
	var contentsLines = contents.split("\n");
	var username = "";
	var password = "";
	
	for ( var i in contentsLines ) {
		if ( contentsLines[i] != '' ) {
			var contentLinePieces = contentsLines[i].split(":");

			if ( typeof contentLinePieces[0] != 'undefined' && typeof contentLinePieces[1] != 'undefined' ) {
				username = contentLinePieces[0];
				password = contentLinePieces[1];
			}
		}
	}
   
    sftp.connect({
	    host: 'lastword.sftp.wpengine.com',
	    port: '2222',
	    username: username,
	    password: password
	}).then(() => {
		var path = __dirname + '/build/static/js/';

		fs.readdir(path, function(err, items) {
		    for (var i=0; i<items.length; i++) {
		    	if ( items[i].indexOf('.js.map') == -1 ) {
		    		var originPath = path + items[i];
		    		var destinationPath = '/wp-content/plugins/email-builder/js/' + items[i];

		    		console.log('File upload started for: ' + items[i]);
		    		
		    		sftp.put(originPath, destinationPath).then(() => {
		    			console.log('File upload ended.');
		    			process.exit(0);
					});
		    	}
		    }
		});
	}).catch((err) => {
	    console.log(err, 'catch error');
	});
});
 