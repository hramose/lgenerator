### Crud Structure ###

After installation, the first thing you have to do is generate the structure of work for the CRUDs generator .

```bash
    php artisan makefast:crudstructure
```

This command will create a directory structure into your `/application_instalation` directory

After this creation, the artisan will copy a serie of templates into 

```

	application_instalation/	
	├── app/
	│	├── ...											
	│	├── Http/
	│	│	└── Controllers/
	│	│	    ├── ...
	│	│		└── cruds/
	│	│	   	  	└── BaseCRUDController.php
	│	├── ...
	│	└── cruds/
	│	  	└── BaseCRUDModel.php
	├── ...
	├── config/
	│	└── cruds/
	│		└── settings.php	
	└── resources/
		├── ...
		├── templates/
		│	└── cruds/
		│		├── controller/
		│		│   └── controller.template.blade.php
		│		├── customs/
		│		├── model/
		│		│   └── model.template.blade.php
		│		└── views/
		│			├── master-detail/
		│			│   ├── detail_tables.template.blade.php
		│			│   ├── detail_tables_item.template.blade.php
		│			│   └── master_record.template.blade.php
		│			├── create.template.blade.php 
		│			├── edit.template.blade.php
		│			├── show.template.blade.php
		│			└── create.template.blade.php
		└── views/					
			├── ...		
			├── cruds/			
			└── system/
				├── ...			
				└── cruds/
					├── header_cruds.php 
					├── footer_cruds.php
					├── header_index_panel.blade.php
					├── datepicker_loader.blade.php					
					├── partial_header_cruds.blade.php					
					├── partial_notifications.blade.php					
					├── notifications_layout.blade.php	
					└── second_column_cruds.blade.php				
```


it's all.

[home](../readme.md)