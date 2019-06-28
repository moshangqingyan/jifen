## isapi-admin安装步骤

isapi-admin使用了composer管理依赖，laravel框架作为项目架构，以及laravel-admin扩展包快速搭建管理后台。
laravel同时也采用composer来管理自身的依赖，因此在安装前必须要先安装composer。
- [laravel5.4中文文档](http://laravelacademy.org/laravel-docs-5_4)
- [laravel-admin中文文档](http://z-song.github.io/laravel-admin/#/zh/)
- [composer中文文档](http://docs.phpcomposer.com/)


### 1.  使用git克隆项目，切换到admin分支

### 2.  使用composer安装依赖

进入项目isapi/admin目录，运行命令 ：

```
composer install
```

该命令将会自动下载项目的依赖包并保存在isapi/admin/vendor目录中。

### 3.  生成.env配置文件

如果当前目录中没有生成.env文件，运行命令：

```php
cp .env.example .env
```

生成配置文件，.env为laravel的配置文件，主要配置项目的部署信息与数据库连接信息。

### 4.  配置.env文件

.env配置项解释：

```php
APP_NAME=isapi-admin
APP_ENV=local  // 项目的部署环境，local为本地环境，
APP_KEY=base64:zr73eysVDTb1+txuThEPCHGkhs4hL7+WFfxw9yLQf3A=  // APP_KEY
APP_DEBUG=true  // 是否开启调试
APP_LOG_LEVEL=debug // 调试等级
APP_URL=http://local.isapi.admin/

// mysql连接信息
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin
DB_USERNAME=homestead
DB_PASSWORD=secret
```

1.  运行laravel控制台命令key:generate生成APP_KEY，

```
php artisan key:generate
```

2.  配置数据库连接信息
3.  其次根据部署的环境填写APP_ENV与APP_DEBUG。默认为本地调试环境。

### 5.  安装laravel-admin

运行laravel控制台命令：

```php
php artisan admin:init
```

该命令做的事情：

- 发布管理后台的前端资源到public目录，包括js、css等。
- 自动生成laravel-admin需要的相关数据表：权限、角色、账号、默认菜单。生成默认账号admin/admin。
- 生成自定义系统菜单

### 6.  安装项目数据表
运行命令

```
php artisan migrate
```

该命令将会在数据库生成本项目的相关数据表。如保险账号、api用户等等

### 7.  设置目录权限

设置当前web服务用户拥有以下目录的全部权限
```
bootstrap/cache/
storage
```
nginx用户配置示例

```
// nginx
chown -R nginx:nginx admin
```

### 8.  导入数据

安装完成。

## Web服务器配置

### 美化URL

- Apache

框架中自带的public/.htaccess文件支持URL中隐藏index.php，如过你的Laravel应用使用Apache作为服务器，需要先确保Apache启用了mod_rewrite模块以支持.htaccess解析。
如果Laravel自带的.htaccess文件不起作用，试试将其中内容做如下替换：

```php
Options +FollowSymLinks
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d 
RewriteCond %{REQUEST_FILENAME} !-f 
RewriteRule ^ index.php [L] 
```
   
- Nginx
   
如果你使用的是Nginx，使用如下站点配置指令就可以支持URL美化：

```
location / {
   try_files $uri $uri/ /index.php?$query_string;
}
```






