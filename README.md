# Download Latest Module with Magento 2.4.x support From Magento Marketplace
# <a href="https://marketplace.magento.com/prince-module-productattachment.html">Download Link</a>

<h3><a href="https://marketplace.magento.com/media/catalog/product/prince-module-productattachment-2-1-8-ce/user_guides.pdf">User Guide</a></h3>

# Magento2 Product Attachment

The Product Attachments extension for Magento 2 equips product pages with a special attachments block where you can upload numerous documents such as user guides, extra images, pdf, certificates, licenses and many others.

# New Features
<ul>
<li>You can now manage attachments from the product edit page</li>
<li>Add multiple new attachments from the product edit page</li>
<li>Assign products to attachment by Product Grid, Product IDs, or by Product Skus</li>
<li>Implement widget to show specific attachments, all attachments or by current product</li>
<li>API support: Now you can manage attachments by APIs.
  <ul>
    <li>Create a new attachment</li>
    <li>Update attachment</li>
    <li>Get attachment</li>
    <li>Delete attachment</li>
    <li>Get attachments data by product id</li>
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

<b><a href="https://demo.mageprince.com/push-it-messenger-bag.html">Frontend</a>   |   <a href="http://demo.mageprince.com/admin">Backend</a></b>

# Code to show attachments on CMS page or Static Block

<b>1) To show all attachments</b>

``{{block class="Mageprince\Productattach\Block\AllAttachment"
template="Mageprince_Productattach::all-attachment.phtml" show_icon=1 show_label=1
show_description=0 show_filetype=0 show_size=1 show_download=1 apply_customer_filter=1
apply_store_filter=1}}``

<b>2) To show attachments of current product</b>
``{{block class="Mageprince\Productattach\Block\AllAttachment"
template="Mageprince_Productattach::all-attachment.phtml" show_icon=1 show_label=1
show_description=0 show_filetype=0 show_size=1 show_download=1 apply_customer_filter=1
apply_store_filter=1 current_product=1}}``

<b>3) To show attachments by file_type</b>

``{{block class="Mageprince\Productattach\Block\AllAttachment" file_type="pdf,doc"
template="Mageprince_Productattach::all-attachment.phtml"}}``

<b>4) To set number of attachments to show</b>

``{{block class="Mageprince\Productattach\Block\AllAttachment" count="10"
template="Mageprince_Productattach::all-attachment.phtml"}}``

<b>5) To show attachment by attachment id(s)</b>

``{{block class="Mageprince\Productattach\Block\AllAttachment" attachment_id="5,6"
template="Mageprince_Productattach::all-attachment.phtml"}}``

# Screenshot

<h3>Product Page - Table View</h3>
<img src="https://marketplace.magento.com/media/catalog/product/7/e/7ec8_01_table_view_description.jpg" heigth="600"/>
<img src="https://marketplace.magento.com/media/catalog/product/8/e/8ed7_03_table_view_tab.jpg" heigth="600"/>

<h3>Product Page - List View</h3>
<img src="https://marketplace.magento.com/media/catalog/product/a/9/a96b_02_list_view_description.jpg" alt="Product Page" heigth="600">
<img src="https://marketplace.magento.com/media/catalog/product/f/a/fa56_04_list_view_tab.jpg" alt="Product Page" heigth="600">

<h3>CMS Page</h3>
<img src="https://marketplace.magento.com/media/catalog/product/3/5/3508_5_cms_page.jpg" alt="CMS page" heigth="600">

<h3>Product Edit Page</h3>
<img src="https://marketplace.magento.com/media/catalog/product/3/e/3eb5_6_admin_product_edit.jpg" alt="Admin Product Edit Page" heigth="600">
<img src="https://marketplace.magento.com/media/catalog/product/0/7/0758_6_admin_product_edit_1.jpg" alt="Admin Product Edit Page" heigth="600">
<img src="https://marketplace.magento.com/media/catalog/product/b/a/ba37_7_admin_product_edit_2.jpg" alt="Admin Product Edit Page" heigth="600">

<h3>Add/Edit Attachment</h3>
<img src="https://marketplace.magento.com/media/catalog/product/6/d/6d3a_10_admin_attachment_edit_1_updated.png" alt="Add Edit Attachment" heigth="600">
<img src="https://marketplace.magento.com/media/catalog/product/f/d/fd97_11_admin_attachment_edit_2.jpg" alt="Add Edit Attachment" heigth="600">
<img src="https://marketplace.magento.com/media/catalog/product/e/7/e740_12_admin_attachment_edit_product.jpg" alt="Add Edit Attachment" heigth="600">

<h3>Add/Edit Attachment Icon</h3>
<img src="https://marketplace.magento.com/media/catalog/product/d/8/d895_13_admin_icon_edit.jpg" alt="Add Edit Attachment" heigth="600">

<h3>Admin Grid</h3>
<img src="https://marketplace.magento.com/media/catalog/product/d/7/d72c_9_admin_grid.jpg" alt="Admin Attachment Grid" heigth="600">

<h3>Configuration</h3>
<img src="https://marketplace.magento.com/media/catalog/product/6/7/67ea_14_configuration_1.jpg" alt="Admin Configuration" heigth="600">
