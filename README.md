composer update 
php artisan migrate => nếu có database + table rồi thì k cần chạy lệnh này

php artisan optimize:clear

// remove khi unzip from macOS
sudo rm -rf /Applications/MAMP/htdocs/vsmartweb.com/Themes/.DS_Store 

// neu bi loi sql -> thi chay lệnh nay
GRANT ALL PRIVILEGES ON sql_vsmartweb_co.* TO 'root'@'%' IDENTIFIED BY 'your_password'; FLUSH PRIVILEGES;

// nếu bị lỗi này T_FUNCTION…
Themes/seobin/views/layouts/link.blade.php

—> thì trong composer.json -> set version sau
 "botble/assets": "1.0.16",

// nếu bị lỗi này  Locale 'en' is not in the list of supported locales. (View: /Applications/MAMP/htdocs/vsmartweb.com/Themes/seobin/views/layouts/header.blade.php)

==> Do trong database set 2 ngôn ngữ mà define có 1 ngôn ngữ
==> vào file này: public/supportedLocales.json -> thêm vào 1 ngôn ngữ


// Nếu image không dc hiển thị -> chạy lệnh bên dưới
chmod -R 755 Themes

// links sử dụng hình ảnh trong thêm
ln -s /Applications/MAMP/htdocs/vsmartweb.com/Themes/seobin /Applications/MAMP/htdocs/vsmartweb.com/public/Themes/seobin

ln -s /Applications/MAMP/htdocs/vsmartweb.com/Themes/admindefault /Applications/MAMP/htdocs/vsmartweb.com/public/Themes/admindefault

ln -s /Applications/MAMP/htdocs/vsmartweb.com/Themes/vsmartweb /Applications/MAMP/htdocs/vsmartweb.com/public/Themes/vsmartweb

Lưu ý: /Applications/MAMP/htdocs/vsmartweb.com ==> là đường dẫn trên máy của bạn


// set queen cho thu mục cache
Sudo chmod -R 777 storage/