# Swordbros Popup For Aimeos Extensions

# Introduction

This plugin supports PHP 7.2 and higher 
You can easily add popup to your website using this plugin.
This plugin is compatible with aimeos version 2020.07.6
# Download

## Composer 

```
Add this line your web site composser.json 
    "require": {
        ...
        "swordbros/sw-popup": "^1.1"
    },
```

## Solving problems with minimal stability

Add to your composer.json

```
    "scripts": {
        "post-update-cmd": [
            ...
            "@php artisan migrate --path=vendor/swordbros/sw-popup/lib/custom/setup/____fix_popup_table.php"

        ]
    }


```
## Add the codes to your js file
```
$(document).ready(function () {

	$('#close-button').on('click', function () {
		$('#myModal').css("display","none")
	});



	window.onclick = function(event) {
		var target = $( event.target );
		if (target.is( "#myModal" )) {
			$('#myModal').css("display","none")
		}
	}

});

```

# If you want to get only data for your template file
```
<?php $popup_data = \Aimeos\Shop\Facades\Shop::get('popup')->addData($this);?>
```


