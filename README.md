# Proje Raporu: Web Uygulaması Geliştirme

**Geliştirici:** Enes Doğanay

**Tarih:** 07.06.2024

## 1. Giriş

Bu rapor, Book Store web uygulamasının geliştirilme sürecini, kullanılan teknolojileri, uygulanan özellikleri ve karşılaşılan zorlukları kapsamaktadır. Bu web uygulaması, yöneticilerin kitaplar, yazarlar, kategoriler ve yayınevleri gibi öğeleri kolayca yönetebileceği ve kullanıcıların da kitapları inceleyip favorilerine ekleyebileceği veya alışveriş sepeti oluşturup satın alabileceği bir platform sağlamaktadır.

## 2. Proje Tanımı

Book Store, PHP, MySQL, JavaScript ve Bootstrap gibi çeşitli kütüphaneler kullanılarak geliştirilmiş bir web uygulamasıdır. Uygulama, yöneticilerin kitap, yazar, kategori ve yayınevleri gibi öğeleri yönetebileceği, kullanıcıların ise kitapları inceleyip alışveriş sepeti oluşturabileceği ve ödeme işlemleri gerçekleştirebileceği bir platform sunar.

## 3. Kullanılan Teknolojiler ve Kütüphaneler

- **PHP**: Sunucu tarafında çalışan betik dili.
- **MySQL**: Veritabanı yönetim sistemi.
- **JavaScript**: Dinamik kullanıcı arayüzleri için.
- **JSON**: Veri değişim formatı.
- **jQuery**: JavaScript kütüphanesi.
- **Bootstrap**: CSS kütüphanesi.
- **PHPMailer**: E-posta gönderimi için PHP kütüphanesi.
- **Stripe**: Online ödeme sistemi entegrasyonu için kullanılan kütüphane.
- **FontAwesome**: İkon kütüphanesi.

## 4. Özellikler

### 4.1 Kullanıcı Yönetimi

- **Kullanıcı Kayıt (register.php)**: Kullanıcıların kayıt olmasını sağlar. Kullanıcı bilgileri doğrulandıktan sonra veritabanına eklenir.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/c646767a-236b-43ae-a2b9-e053ca350ae6)

- **Kullanıcı Giriş (login.php)**: Kayıtlı kullanıcıların sisteme giriş yapmasını sağlar. Giriş bilgileri doğrulandıktan sonra oturum başlatılır.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/c184114c-eada-49a5-9f57-fa38a244e511)

- **Şifre Sıfırlama İsteği (reset-password-request.php)**: Kullanıcıların mail adreslerini girerek şifre sıfırlama isteği gönderebilmesini sağlar.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/8387b58f-a8e3-444d-ba0e-4769a83b3b3b)

- **Şifre Sıfırlama (reset-password.php)**: Kullanıcıların gelen şifre sıfırlama tokenı bulunan mail ile ulaşıp yeni şifrelerini girerek şifre sıfırlayabilmesini sağlar.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/0d4374d6-7520-44a6-bc05-df227a33dcd2)

- **Hesaptan Çıkış Yapma (logout.php)**: Kullanıcıların hesaplarından çıkış yapabilmesini sağlar.

### 4.2 Veritabanı İşlemleri

CRUD (Create, Read, Update, Delete) işlemleri. Veritabanı tasarımı ve ilişkisel veritabanı yönetimi. MySQL kullanarak veritabanı işlemlerinin gerçekleştirilmesi.

#### Kitaplar İçin

- **Kitap Ekleme (add-book.php)**: Yeni kitap ekler. Kitap bilgileri doğrulandıktan sonra veritabanına kaydedilir.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/12048824-59e9-4fb9-a102-f7e490567f02)  
![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/a1ff18d1-b6a5-45d6-901d-c186792f5abb)

- **Kitapları Görüntüleyip Düzenleme (edit-books.php)**: Kitapları görüntüleyip düzenleme ve silme işlemlerini yapmak için gerekli sayfalara yönlendirir.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/9ae9dc9f-8650-4bbc-bcb8-3218eb3582eb)

- **Kitap Düzenleme (edit-book.php)**: Mevcut kitap bilgilerini günceller.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/3023e0d7-e950-40c0-849e-52f085769eeb)
![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/c223bc0b-eb3c-43a4-8c90-91f98fe0a74c)

- **Kitap Silme (delete-book.php)**: Belirtilen kitabı veritabanından siler.
- **Kitap Detayı (book-detail.php)**: Kitap hakkında detaylı bilgi görüntüler.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/48f02c06-07a1-48f4-b10d-61e651576a0e)
![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/aeee7ef7-d5fa-4b85-a1a5-252c96cae0e6)


#### Yazarlar İçin

- **Yazar Ekleme (add-author.php)**: Yeni yazar ekler.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/fec8eac9-5890-4d8a-9b86-f9a16b8bb0f8)

- **Yazarları Görüntüleyip Düzenleme (edit-authors.php)**: Yazarları görüntüleyip düzenleme ve silme işlemlerini yapmak için gerekli sayfalara yönlendirir.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/4911f79b-0a2e-4c2a-a319-f51af2163bf8)

- **Yazar Düzenleme (edit-author.php)**: Yazar bilgilerini günceller.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/fe3bca93-4705-441c-ba11-73708dced721)

- **Yazar Silme (delete-author.php)**: Yazarı veritabanından siler.

#### Kategoriler İçin

- **Kategori Ekleme (add-category.php)**: Yeni kategori ekler.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/c357a6d2-2d09-400d-af35-7ee45b7dff6f)

- **Kategorileri Görüntüleyip Düzenleme (edit-categories.php)**: Kategorileri görüntüleyip düzenleme ve silme işlemlerini yapmak için gerekli sayfalara yönlendirir.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/d35fa72a-9537-4fc0-bdf5-fd622eafe247)

- **Kategori Düzenleme (edit-category.php)**: Kategori bilgilerini günceller.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/5a6e29fb-b00a-42c4-b853-e1cef2135b54)

- **Kategori Silme (delete-category.php)**: Kategoriyi veritabanından siler.

#### Yayınevi İçin

- **Yayınevi Ekleme (add-publisher.php)**: Yeni yayınevi ekler.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/36d3f4d2-39ba-469d-88ba-9ec9e4dd5311)

- **Yayınevlerini Görüntüleyip Düzenleme (edit-publishers.php)**: Yayınevlerini görüntüleyip düzenleme ve silme işlemlerini yapmak için gerekli sayfalara yönlendirir.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/bccbb4f7-eb27-4b10-89c3-f42fbdd29d3e)

- **Yayınevi Düzenleme (edit-publisher.php)**: Yayınevi bilgilerini günceller.

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/2ac7e383-72c2-4d66-ad01-fd6c69ef79b3)

- **Yayınevi Silme (delete-publisher.php)**: Yayınevini veritabanından siler.


### **4.3 Form Yönetimi**
- Veri doğrulama ve hata yönetimi.
- Kullanıcıdan alınan verilerin işlenmesi ve saklanması.

### **4.4 Dosya Yükleme**
- Kullanıcıların dosya yükleyebilmesi (örneğin resim yükleme).
- Yüklenen dosyaların sunucuda güvenli bir şekilde saklanması.

### **4.5 JSON ve RESTful API**
- JSON formatında veri alışverişi.
- RESTful API oluşturma ve kullanma.
- API üzerinden veri alma ve gönderme işlemleri.

### **4.6 Oturum Yönetimi**
- PHP Sessions kullanarak oturum yönetimi.
- Kullanıcı oturumlarının güvenli bir şekilde yönetilmesi.

### **4.7 Güvenlik**
- Güvenlik önlemleri (örneğin CSRF, XSS korumaları, SQL Injection korumaları).
- Kullanıcı verilerinin güvenliğinin sağlanması.

### **4.8 PHP OOP ve Mysqli**
- Nesne yönelimli programlama (OOP) prensiplerine uygun kod yazma.
- PHP Mysqli kullanarak veritabanı işlemleri gerçekleştirme.

### **4.9 Ekstra Özellikler**
### **E-posta Bildirimleri**: 
Kullanıcılara e-posta bildirimleri gönderme.   

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/dc838540-c01a-49fd-ab6e-4276e72b3b4d)
![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/cfec7c5f-cb40-4c6b-aba3-7c144746c4b3)

### **Ödeme Entegrasyonu**: 
Online ödeme sistemleri ile entegrasyon (Stripe).  

![image](https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi/assets/71710802/762811c9-b562-48c6-9841-76a3674449c7)

- **Test Kredi Kartı Bilgileri**   
  Kart Numarası ve CCV görselde gösterildiği gibi olmalıdır.    
  Tarih için geçmemiş bir tarih kullanmanız yeterlidir.    
  Posta kodu için de 5 basamaklı herhangi bir sayı kullanabilirsiniz.    

## 5. Kurulum ve Kurulum Talimatları

### 5.1 Gereksinimler

- Web sunucusu (Apache, Nginx vb.)
- PHP 7.4 veya üzeri
- MySQL 5.7 veya üzeri
- Composer

### 5.2 Kurulum Adımları

1. Depoyu klonlayın:
   ```sh
   git clone https://github.com/Enes-Doganay/PeopleBox-BitirmeProjesi.git
2. Composer bağımlılıklarını yükleyin:
   ```sh
   composer install
3. Veritabanı bağlantısını yapılandırın:  
- Models klasörü altında database.php dosyasından veritabanı ayarlarını düzenleyin.
4. Veritabanı tablolarını oluşturun:
- Projede sağlanan SQL betiklerini kullanarak tabloları oluşturun. Repodaki sql dosyasını içe aktar diyerek aktarabilirsiniz.
5. Uygulamayı bir web sunucusunda dağıtın:
- Php sunucusu olan XAMPP, WAMP veya benzeri bir local sunucu kullanabilirsiniz.
6. Proje dosyalarını sunucu klasörüne taşıyın:
- XAMPP için htdocs klasörüne taşıyın.
7. Web tarayıcınızı kullanarak proje dizinine erişin ve uygulamayı çalıştırın.

## **6. Test Senaryoları**

### **6.1 Kullanıcı Kayıt Testi**

Senaryo: Yeni bir kullanıcı sisteme kayıt olur.
- **Giriş**: Kullanıcı, kayıt formunu doğru bilgilerle doldurur.
- **Adımlar**:
  1. Kayıt formuna isim, e-posta ve şifre girilir.
  2. Kayıt butonuna tıklanır.
- **Çıkış**: Kullanıcı başarıyla kayıt olur. Kayıt başarılı modalı gösterilir ve giriş yapma ekranına yönlendirilir.

### **6.2 Kullanıcı Giriş Testi**

Senaryo: Kayıtlı bir kullanıcı sisteme giriş yapar.
- **Giriş**: Kullanıcı, giriş formunu doğru bilgilerle doldurur.
- **Adımlar**:
  1. Giriş formuna e-posta ve şifre girilir.
  2. Giriş butonuna tıklanır.
- **Çıkış**: Kullanıcı başarıyla giriş yapar ve ana sayfaya yönlendirilir.

### **6.3 Kitap Ekleme Testi**

Senaryo: Yönetici yeni bir kitap ekler.
- **Giriş**: Yönetici, kitap ekleme formunu doldurur.
- **Adımlar**:
  1. Kitap adı, yazar, kategori ve yayıncı bilgileri girilir.
  2. Kaydet butonuna tıklanır.
- **Çıkış**: Kitap başarıyla eklenir ve kitap ekleme başarılı mesajı çıkar.

### **6.4 Alışveriş Sepeti Testi**

Senaryo: Kullanıcı bir kitabı alışveriş sepetine ekler.
- **Giriş**: Kullanıcı, kitap detay sayfasına gider.
- **Adımlar**:
  1. "Sepete Ekle" butonuna tıklanır.
- **Çıkış**: Kitap başarıyla sepete eklenir ve kullanıcı sepetini görüntüler.

### **6.5 Ödeme Testi**

Senaryo: Kullanıcı sepetindeki kitapları satın alır.
- **Giriş**: Kullanıcı, ödeme sayfasına gider.
- **Adımlar**:
  1. Ödeme bilgilerini girer.
  2. "Ödeme Yap" butonuna tıklanır.
- **Çıkış**: Ödeme başarıyla gerçekleştirilir. Kullanıcıya onay mesajı gösterilir ve fatura mail olarak iletilir.
