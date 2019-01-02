# phpSqlyog


大概就是随便放个php的根目录就可以用了

nginx 配置参考:

	location ~* /phpSqlyog(.*)$ {
		root  you/file/path;
		index index.html index.htm index.php;
	
		location ~ \.php(.*)$ {
		    fastcgi_pass   127.0.0.1:9000;
		    fastcgi_index  index.php;
		    fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
		    fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
	    	include        fastcgi_params;
		}
	}

