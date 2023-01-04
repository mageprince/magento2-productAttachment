# Download Latest Module with Magento 2.4.x support From Magento Marketplace
# <a href="https://marketplace.magento.com/mageprince-module-product-attachment.html">Download Link</a>

<h3><a href="https://marketplace.magento.com/media/catalog/product/mageprince-module-product-attachment-2-2-0-ce/user_guides.pdf">User Guide</a></h3>

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
<img src="https://user-images.githubusercontent.com/24751863/210595155-337b0a8e-06f4-48f9-9248-fe58eeb95f44.jpg"/>
<img src="https://user-images.githubusercontent.com/24751863/210595207-f32946d9-3ce7-4bcb-96a4-1768b1a6a81c.jpg"/>

<h3>Product Page - List View</h3>
<img src="https://user-images.githubusercontent.com/24751863/210595243-59df1953-f741-4600-8e00-c6aaaf6f6ba6.jpg"/>
<img src="https://user-images.githubusercontent.com/24751863/210595273-44fb52aa-6626-4702-89d6-cacdaeb655b8.jpg"/>

<h3>CMS Page</h3>
<img src="https://user-images.githubusercontent.com/24751863/210595318-cf32f588-51d4-46d4-b19d-9ec14482024d.jpg"/>

<h3>Product Edit Page</h3>
<img src="https://user-images.githubusercontent.com/24751863/210595439-a9627eec-4de8-47f1-8bf8-9dc94089936f.jpg"/>
<img src="https://user-images.githubusercontent.com/24751863/210595457-11b5806b-d445-4292-a63b-0f7e75034573.jpg"/>
<img src="https://user-images.githubusercontent.com/24751863/210595469-d482f5f1-efdd-476e-bf61-c7e97c8d301a.jpg"/>

<h3>Add/Edit Attachment</h3>
<img src="https://user-images.githubusercontent.com/24751863/210595740-64e6f11c-f7ae-4e65-a29c-2c066ece1ff1.png"/>
<img src="https://user-images.githubusercontent.com/24751863/210595661-3a2389a1-f360-43fc-ac26-e70fa0334642.jpg"/>

<h3>Add/Edit Attachment Icon</h3>
<img src="https://user-images.githubusercontent.com/24751863/210595782-4093aa4b-1d95-473b-8bc1-9ae693e8c7f7.jpg"/>

<h3>Admin Grid</h3>
<img src="https://user-images.githubusercontent.com/24751863/210595834-8acbb5e8-07ce-4b01-8543-49a7af7aa0f0.jpg"/>

<h3>Configuration</h3>
<img src="https://user-images.githubusercontent.com/24751863/210595890-f54de0a2-df3e-488c-b657-3e65e9570863.jpg"/>
