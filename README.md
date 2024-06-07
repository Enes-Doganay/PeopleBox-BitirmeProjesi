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
- **Kullanıcı Giriş (login.php)**: Kayıtlı kullanıcıların sisteme giriş yapmasını sağlar. Giriş bilgileri doğrulandıktan sonra oturum başlatılır.
- **Şifre Sıfırlama İsteği (reset-password-request.php)**: Kullanıcıların mail adreslerini girerek şifre sıfırlama isteği gönderebilmesini sağlar.
- **Şifre Sıfırlama (reset-password.php)**: Kullanıcıların gelen şifre sıfırlama tokenı bulunan mail ile ulaşıp yeni şifrelerini girerek şifre sıfırlayabilmesini sağlar.
- **Hesaptan Çıkış Yapma (logout.php)**: Kullanıcıların hesaplarından çıkış yapabilmesini sağlar.

### 4.2 Veritabanı İşlemleri

CRUD (Create, Read, Update, Delete) işlemleri. Veritabanı tasarımı ve ilişkisel veritabanı yönetimi. MySQL kullanarak veritabanı işlemlerinin gerçekleştirilmesi.

#### Kitaplar İçin

- **Kitap Ekleme (add-book.php)**: Yeni kitap ekler. Kitap bilgileri doğrulandıktan sonra veritabanına kaydedilir.
- **Kitapları Görüntüleyip Düzenleme (edit-books.php)**: Kitapları görüntüleyip düzenleme ve silme işlemlerini yapmak için gerekli sayfalara yönlendirir.
- **Kitap Düzenleme (edit-book.php)**: Mevcut kitap bilgilerini günceller.
- **Kitap Silme (delete-book.php)**: Belirtilen kitabı veritabanından siler.
- **Kitap Detayı (book-detail.php)**: Kitap hakkında detaylı bilgi görüntüler.

#### Yazarlar İçin

- **Yazar Ekleme (add-author.php)**: Yeni yazar ekler.
- **Yazarları Görüntüleyip Düzenleme (edit-authors.php)**: Yazarları görüntüleyip düzenleme ve silme işlemlerini yapmak için gerekli sayfalara yönlendirir. 
- **Yazar Düzenleme (edit-author.php)**: Yazar bilgilerini günceller.
- **Yazar Silme (delete-author.php)**: Yazarı veritabanından siler.

#### Kategoriler İçin

- **Kategori Ekleme (add-category.php)**: Yeni kategori ekler.
- **Kategorileri Görüntüleyip Düzenleme (edit-categories.php)**: Kategorileri görüntüleyip düzenleme ve silme işlemlerini yapmak için gerekli sayfalara yönlendirir. 
- **Kategori Düzenleme (edit-category.php)**: Kategori bilgilerini günceller.
- **Kategori Silme (delete-category.php)**: Kategoriyi veritabanından siler.

#### Yayınevi İçin

- **Yayınevi Ekleme (add-publisher.php)**: Yeni yayınevi ekler.
- **Yayınevlerini Görüntüleyip Düzenleme (edit-publishers.php)**: Yayınevlerini görüntüleyip düzenleme ve silme işlemlerini yapmak için gerekli sayfalara yönlendirir. 
- **Yayınevi Düzenleme (edit-publisher.php)**: Yayınevi bilgilerini günceller.
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

### **Ödeme Entegrasyonu**: 
Online ödeme sistemleri ile entegrasyon (Stripe).
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
