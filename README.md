# Download Latest Module with Magento 2.3.x support From Magento Marketplace
# <a href="https://marketplace.magento.com/prince-module-productattachment.html">Download Link</a>

<h3><a href="https://marketplace.magento.com/media/catalog/product/prince-module-productattachment-2-0-0-ce/user_guides.pdf">User Guide</a></h3>

# Magento2 Product Attachment

The Product Attachments extension for Magento 2 equips product pages with a special attachments block where you can upload numerous documents such as user guides, extra images, pdf, certificates, licenses and many others.

# New Features
<ul>
<li>You can now manage attachments from the product edit page</li>
<li>API support: Now you can manage attachments by APIs.
  <ul>
    <li>Create a new attachment</li>
    <li>Update attachment</li>
    <li>Get attachment</li>
    <li>Delete attachment</li>
  </ul> 
</li>
<li>Product API support: Now you can also manage attachments with product API
  <ul>
    <li>Assign/Remove attachments from the product</li>
    <li>Get attachments</li>
  </ul>  
</li>
</ul>

<b>Check full description on <a href="https://marketplace.magento.com/prince-module-productattachment.html">Magento Marketplace</a></b>

# Demo

<b><a href="http://demo.mageprince.com/">Frontend</a>   |   <a href="http://demo.mageprince.com/admin">Backend</a></b>

# Code to show attachments on CMS page or Static Block

<b>1) To show all attachments</b>

``{{block class="Mageprince\Productattach\Block\AllAttachment"
template="Mageprince_Productattach::all-attachment.phtml" show_icon=1
show_label=1 show_description=0 show_filetype=0 show_size=1
show_download=1 apply_customer_filter=1 apply_store_filter=1}}``

<b>2) To show attachments by file_type</b>

``{{block class="Mageprince\Productattach\Block\AllAttachment"
file_type="pdf,doc" template="Mageprince_Productattach::allattachment.phtml"}}``

<b>3) To set number of attachments to show</b>

``{{block class="Mageprince\Productattach\Block\AllAttachment" count="10"
template="Mageprince_Productattach::all-attachment.phtml"}}``

<b>4) To show attachment by attachment id(s)</b>

``{{block class="Mageprince\Productattach\Block\AllAttachment"
attachment_id="5,6" template="Mageprince_Productattach::allattachment.phtml"}}``

# Screenshot

<h3>Product Page - Table View</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/1-productattachment.png" alt="Product Page">

<h3>Product Page - List View</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/2-productattachment.png" alt="Product Page">

<h3>CMS Page</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/3.1-productattachment.png" alt="CMS page">

<h3>Product Edit Page</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/3.2-productattachment.jpg" alt="Admin Product Edit Page">

<h3>Admin Grid</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/5-productattachment-grid.png" alt="Admin Attachment Grid">

<h3>Configuration</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/8-productattachment.png" alt="Admin Configuration">
