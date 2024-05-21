## วิธีติดตั้งระบบ

# วิธี config setup ระบบ 


1. ทำการ `Copy` ไฟล์ `example-env-config`\

2. นำมาวางที่ ~ root folder ของโปรเจคและทำการเปลี่ยนชื่อไฟล์เป็น `env-config.php` \

3. จากนั้นทำการ `setup` ไฟล์ `env-config.php` ให้พร้อมใช้งาน\

## ตัวอย่าง


``` 
     define("DATABASE_HOSTNAME","");  localhost ที่ใช่ปัจจุบัน
     define("DATABASE_USERNAME",""); ชื่อผู้ใช้ database ปัจจุบัน
     define("DATABASE_PASSWORD",""); รหัสผ่าน database ปัจจุบัน
     define("DATABASE_NAME","");  ชื่อ database ปัจจุบัน 
     define("URL_API","http://localhost:port/api/"); localhost:post  ที่ใช่ปัจจุบัน; 
     define("URL_HOST","http://localhost:port/");  localhost:post  ที่ใช่ปัจจุบัน

```
4. ทำการใส่ข้อมูลตามลำดับ และ `save` ไฟล์ให้เรียบร้อย

5. ทำการ start server ในเครื่อง เช่น --MAMP --XAMPP  --Docker เป็นหลัก
6. หลังจากที่ start server แล้วสามารถ ทดสอบ ตาม `URL: http://localhost:port/` นี้ได้เลย 

** http://localhost:port/ port server ปัจจุบัน

## user admin
```
  username : supperadmin
  password : Z@KyR51[b|7uV0i[VMSl
  
```