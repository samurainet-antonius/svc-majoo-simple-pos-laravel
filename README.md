<h2>Majoo Teknologi Indonesia - POS Mini</h2>
<p>svc-majoo-simple-pos-laravel merupakan Aplikasi POS yang dibuat secara Fullstack dengan menggunakan framework Laravel, library Jquery dan AJAX, yang mengadopsi software Arsiktektur monolithic, yang didalam nya terdapat user interface (Frontend) dan juga RESTfull API (Backend)</p>
<p>Service ini dibuat dengan menggunakan bahasa pemrograman PHP (Framework Laravel) dan DBMS MySQL.</p>

<p>Berikut ini syarat-syarat yang diperlukan untuk menjalankan service berikut.</p>
<ol>
  <li>PHP >= 7.4.9</li>
  <li>OpenSSL PHP Extension</li>
  <li>PDO PHP Extension</li>
  <li>Mbstring PHP Extension</li>
  <li>DBMS MySQL</li>
  <li>Text Editor (VScode, Sublime Text)</li>
  <li>Command Prompt Line/Terminal/Gitbash</li>
  <li>Composer</li>
  <li>Node v14.17.5</li>
  <li>NPM v6.14.14</li>
 </ol>
 
 <p>Berikut ini dokumentasi api yang akan digunakan, dokumentasi ini akan berubah tanpa adanya pemberitahuan sesuai dengan update pada aplikasi.</p>
 <a href="https://documenter.getpostman.com/view/9640381/UVByHUxx" target="_blank">Dokumentasi API using Postman</a>
 <p><i>*</i> Menu pelanggan, user, transaksi dan lapoaran pada hak akses admin belum tersedia</p>
 <p><i>*</i> Register, Verify, Login untuk pelanggan belum tersedia</p>
 <p><i>*</i> Checkout pada hak akses pelanggan belum tersedia</p>
 
 <h3>Fitur POS Mini Majoo v1.0</h3>
 <br/>
<b>Admin</b>
<ol>
<li>Login</li>
<li>Logout</li>
<li>Create Category</li>
<li>Read Category</li>
<li>Update Category</li>
<li>Delete Category</li>
<li>Create Products</li>
<li>Read Products</li>
<li>Update Products</li>
<li>Delete Products</li>
</ol>
<br/>
<p>Pada halaman login yang ada di home digunakan untuk login sebagai admin saja dengan credentials sebagai berikut.</p>
<ol>
    <li>email : admin@admin.com</li>
    <li>password : admin1234</li>
</ol>

<p>Berikut langkah-langkah yang harus dilakukan setelah mengcloning repository ini.</p>
<ol>
    <li>Jalankan perintah <code>composer install</code> pada terminal atau cmd yang direktorinya berada pada folder project yang sudah diclone</li>
    <li>Setelah itu jalankan <code>npm install && npm run dev</code></li>
    <li>Setelah kedua perintah diatas selesai, selanjutnya melakukan migrations beserta seeder dengan perinta <code>php artisan migrate --seed</code></li>
    <li>Terakhir jalankan perintah <code>php artisan serve</code> untuk menjalakan aplikasi tersebut.</li>
</ol>

<p>Terima Kasih semoga bermanfaat.</p>
