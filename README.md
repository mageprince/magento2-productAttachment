# Download Latest Module with Magento 2.4.x support From Magento Marketplace
# <a href="https://marketplace.magento.com/mageprince-module-product-attachment.html">Download Link</a>

<h3><a href="https://commercemarketplace.adobe.com/media/catalog/product/mageprince-module-product-attachment-2-2-7-ece/user_guides.pdf">User Guide</a></h3>

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

<b>Check full description on <a href="https://commercemarketplace.adobe.com/mageprince-module-product-attachment.html#description">Magento Marketplace</a></b>

# Demo

<b><a href="https://demo.mageprince.com/push-it-messenger-bag.html">Frontend</a>   |   <a href="http://demo.mageprince.com/admin">Backend</a></b>

# Code to show attachments on CMS page or Static Block

<b>1) To show all attachments</b>

```
{{block class="Mageprince\Productattach\Block\AllAttachment"
template="Mageprince_Productattach::all-attachment.phtml" show_icon=1 show_label=1
show_description=0 show_filetype=0 show_size=1 show_download=1 apply_customer_filter=1
apply_store_filter=1}}
```

<b>2) To show attachments of current product</b>
```
{{block class="Mageprince\Productattach\Block\AllAttachment"
template="Mageprince_Productattach::all-attachment.phtml" show_icon=1 show_label=1
show_description=0 show_filetype=0 show_size=1 show_download=1 apply_customer_filter=1
apply_store_filter=1 current_product=1}}
```

<b>3) To show attachments by file_type</b>

```
{{block class="Mageprince\Productattach\Block\AllAttachment" file_type="pdf,doc"
template="Mageprince_Productattach::all-attachment.phtml"}}
```

<b>4) To set number of attachments to show</b>

```
{{block class="Mageprince\Productattach\Block\AllAttachment" count="10"
template="Mageprince_Productattach::all-attachment.phtml"}}
```

<b>5) To show attachment by attachment id(s)</b>

```
{{block class="Mageprince\Productattach\Block\AllAttachment" attachment_id="5,6"
template="Mageprince_Productattach::all-attachment.phtml"}}
```

# Screenshot

<h3>Product Page - Table View</h3>
<img src="https://commercemarketplace.adobe.com/media/catalog/product/2/9/2932_01_table_view_description_2.jpg"/>
<img src="https://commercemarketplace.adobe.com/media/catalog/product/d/d/dd15_03_table_view_tab_2.jpg"/>

<h3>Product Page - List View</h3>
<img src="https://commercemarketplace.adobe.com/media/catalog/product/e/f/efda_02_list_view_description_2.jpg"/>
<img src="https://commercemarketplace.adobe.com/media/catalog/product/2/4/244e_04_list_view_tab_2.jpg"/>

<h3>CMS Page</h3>
<img src="https://commercemarketplace.adobe.com/media/catalog/product/4/1/4155_5_cms_page_2.jpg"/>

<h3>Product Edit Page</h3>
<img src="https://commercemarketplace.adobe.com/media/catalog/product/9/1/915c_6_admin_product_edit_2.jpg"/>
<img src="https://commercemarketplace.adobe.com/media/catalog/product/9/1/9122_7_admin_product_edit_2_2.jpg"/>
<img src="https://commercemarketplace.adobe.com/media/catalog/product/3/b/3b60_6_admin_product_edit_1_2.jpg"/>

<h3>Add/Edit Attachment</h3>
<img src="https://commercemarketplace.adobe.com/media/catalog/product/7/3/730f_10_admin_attachment_edit_1_2.jpg"/>
