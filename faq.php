<?php
include 'layouts/header.php';
?>
    <div class="empty-space col-xs-b35 col-md-b30"></div>
    <!-- Main Container -->
    <section class="main-container col1-layout page-faq">

        <div class="container faq">
            <div style="text-align:center;">
            <img id="faq" style="margin-bottom:2%;" src="assets/img/banner/faq.png">
            </div>

            <button class="accordion">When will I receive my order? <i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: It depends on the quantity of your ordered product. Usually we deliver within 3-7 business days. However, we also provide other delivery options which you can check from our Ship & Pay Policy.</p>
            </div>

            <button class="accordion">What if the product I purchase isn’t the right fit, damaged, incorrect or isn’t needed anymore? <i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: In any such unfortunate circumstances you may check our website for the Return Policy given in the product description.</p>
            </div>

            <button class="accordion">Do you have any store from where I can directly purchase my products? <i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: We surely do. You can visit our store in Birmingham to get the product you need. However, if you’re looking to make a bulk order, do let us know beforehand so we can have your products ready when you arrive.</p>
            </div>
            <button class="accordion">Do you provide refund?<i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: We aim to cater our customer’s every need. If you are looking for a refund or want to return the product you just purchased, please check our Return Policy for details regarding your refund.</p>
            </div>
            <button class="accordion">What is Return Policy?<i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: For every product, various factors apply. To make sure our customers get the best experience from our services, we advise them to read out our Return Policy given in the product description.</p>
            </div>
            <button class="accordion">What are the shipping options?<i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: We offer free shipping for our 3-7 business days deliver option. Moreover, we charge €10 for 2 day delivery.</p>
            </div>
            <button class="accordion"> What do I do if I haven’t received my order? <i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: If you haven’t received your order within 3-7 days, please contact our customer care or call us through our helpline. </p>
            </div>
            <button class="accordion">How do I make changes to an order I’ve already placed? <i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: You can always place a new order. However, you can make changes to your order if you contact us within 10 hours of your order placement.</p>
            </div>
            <button class="accordion"> Where are you located? <i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: We are located at 170 Slade Road, Erdington, Birmingham, B23 7PX, UK. You can also personally place an order by visiting us in business hours.</p>
            </div>
            <button class="accordion">How do I make sure I order the right product? <i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: To make sure you order the right product, please confirm the Part Number in the product description.</p>
            </div>
            <button class="accordion">How do I contact your company if my question isn’t answered here? <i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: We make sure our services live up to our name & expectations. Therefore, in any circumstance our customer care provider will reach out to in no time. Furthermore, you can always get in touch with us through our helpline.</p>
            </div>
            <button class="accordion">What do you mean by refurbished? / What type of product is a refurbished product?<i style="float:right;" class="fa fa-plus"></i></button>
            <div class="panel">
            <p>Answer: All of our products here on Subserve are certified refurbished products that are usually used items that customers have returned due to a defect or because they've changed their minds. They can also be product demos or items with packaging damaged in handling. To prepare an item for resale, the manufacturer puts it through a detailed refurbishing process to make necessary repairs. This can involve cleaning, running functionality tests and repackaging. For example, if someone returns a laptop with a defective screen, the manufacturer will replace the screen, clean the exterior of the laptop to remove signs of use, check all the laptop's functions and repackage it with its accessories and manuals. After a final check, the manufacturer certifies the product as refurbished and can sell it. So your basically getting the real thing but in a far cheaper price. For further details please contact our customer support.</p>
            </div>
        </div>

    </section>
    <!-- Main Container End -->

<?php
include('layouts/footer-scripts2.php');
?>

<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>



<?php
include 'layouts/footer-end.php';
?>