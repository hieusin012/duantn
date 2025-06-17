##Quy trình chạy dự án

**Bước 1:**
Sử dụng git clone để clone dự án
```bash
git clone https://github.com/hieusin012/duantn.git
```

**Bước 2:**
Cài đặt toàn bộ thư viện JS
```bashbash
# create node_modules folder
npm install
```

**Bước 3:**
Cài đặt toàn bộ thư viện PHP
```bash
# create vendor folder
composer update
```
**Bước 4:**
Tạo file `.env`
- Copy file `.env.example` => `.env`
-Cấu hình file `.env`

**Bước 5:**
Build JS, CSS qua thư mục public
```bash
npm run build
```

**Bước 6:**
Tạo Database và bảng trong DB
```bash
php artisan migrate
```

**Bước 7**
Tạo dữ liệu mẫu
```bash
php artisan db:seed
```
**Bước 8:**
```bash
php artisan key:generate
```
**Bước 9:**
Khởi chạy dự án
- Cách 1:
```bash
npm run dev
php artisan serve
```
- Cách 2:
```bash
composer run dev
```
