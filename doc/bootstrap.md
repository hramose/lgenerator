## Requirements ##

IMPORTANT !!!
**This package requires Twitter Bootstrap 3**
If your project still is not using Twitter Bootstrap 3 (TWBS), do not worry, the package includes the dependence necessary for Bootstrap is downloaded to your project.
In this case after run **composer update** just make this to create an asset entry for TWBS in your /public directory:

in the console:

LINUX

```bash
cd application_instalation/ (**where is your composer.json**)
mkdir public/assets/plugins
mkdir public/assets/plugins/bootstrap
cd public/assets/plugins/bootstrap/
ln -s ../../../../components/bootstrap ./bootstrap
```

WIN

```bash
create a directory into `application_instalation/public/assets/plugins/bootstrap/bootstrap`
after
copy the entire dir: `application_instalation/components/bootstrap` into `application_instalation/public/assets/plugins/bootstrap/bootstrap`
```

then you may see:

```

	application_instalation/
	├── ...	
	└── public/
		└── assets/
			└── plugins/
				└── bootstrap/
					└── bootstrap/
						├── css/
						│   ├── bootstrap.css
						│   ├── bootstrap.css.map
						│   ├── bootstrap.min.css
						│   ├── bootstrap-theme.css
						│   ├── bootstrap-theme.css.map
						│   └── bootstrap-theme.min.css
						├── js/
						│   ├── bootstrap.js
						│   └── bootstrap.min.js
						└── fonts/
						    ├── glyphicons-halflings-regular.eot
						    ├── glyphicons-halflings-regular.svg
						    ├── glyphicons-halflings-regular.ttf
						    ├── glyphicons-halflings-regular.woff
						    └── glyphicons-halflings-regular.woff2             		 		   			  
```

(*for more info and docs see https://github.com/twbs/bootstrap*)


[home](../readme.md)