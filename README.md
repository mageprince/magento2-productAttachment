# Magento2 Product Attachment

The Product Attachments extension for Magento 2 adds a dedicated attachments section to your product pages, allowing you to upload a variety of files—user guides, additional images, PDFs, certificates, licenses, and more.

### <a href="https://marketplace.magento.com/mageprince-module-product-attachment.html">Download Link</a>
### <a href="https://github.com/user-attachments/files/20026605/product_attachment_user_guides.pdf">User Guide</a>


# ✨ Features

- Manage and add multiple attachments directly from the product edit page
- Import/export attachments for easy data handling
- Assign attachments to products using product grid, IDs, or SKUs
- Display attachments via widget: all, specific, or current product-based
- Include attachments in new order confirmation emails and sitemaps
- Full API support to create, update, retrieve, and delete attachments
- Product API support to assign/remove attachments and fetch data
- GraphQL support to fetch attachments by product ID and retrieve icons
- Upload unlimited attachments with title, icon, and file size display
- Download attachments from the grid or edit form
- Simple attachment management with customer group & store view restrictions
- Add attachments as downloadable links
- Customize attachment labels and visibility of the Product Attachment tab
- Show file size on the frontend
- Choose between table view or list view for displaying attachments
- Hyvä theme compatibility
- Supports various file formats: jpg, jpeg, gif, png, pdf, csv, bmp, txt, doc, docx, xls, xlsx, rtf, ppt, pptx, zip and many more

<b>Check full description on <a href="https://commercemarketplace.adobe.com/mageprince-module-product-attachment.html#description">Magento Marketplace</a></b>

# 📺 Demo

<b><a href="https://demo.mageprince.com/push-it-messenger-bag.html">Frontend</a>   |   <a href="http://demo.mageprince.com/admin">Backend</a></b>

# Code to show attachments on CMS page or Static Block

**Display all attachments:**
```
{{block class="Mageprince\Productattach\Block\AllAttachment" template="Mageprince_Productattach::all-attachment.phtml" show_icon=1 show_label=1 show_description=0 show_filetype=0 show_size=1 show_download=1 apply_customer_filter=1 apply_store_filter=1}}
```

**Display attachments for the current product:**
```
{{block class="Mageprince\Productattach\Block\AllAttachment" template="Mageprince_Productattach::all-attachment.phtml" show_icon=1 show_label=1 show_description=0 show_filetype=0 show_size=1 show_download=1 apply_customer_filter=1 apply_store_filter=1 current_product=1}}
```

**Display attachments by file type (e.g., PDF, DOC):**
```
{{block class="Mageprince\Productattach\Block\AllAttachment" file_type="pdf,doc" template="Mageprince_Productattach::all-attachment.phtml"}}
```

**Limit the number of attachments displayed:**
```
{{block class="Mageprince\Productattach\Block\AllAttachment" count="10" template="Mageprince_Productattach::all-attachment.phtml"}}
```

**Show specific attachments by ID:**
```
{{block class="Mageprince\Productattach\Block\AllAttachment" attachment_id="5,6" template="Mageprince_Productattach::all-attachment.phtml"}}
```

# 📸 Screenshots

![01_table_view_description](https://github.com/user-attachments/assets/1506b29e-4481-4001-9a34-7fbe99a6f359)
![03_table_view_tab](https://github.com/user-attachments/assets/11ce96bd-f654-4160-9bc9-3ca919813c3d)
![02_list_view_description](https://github.com/user-attachments/assets/024236d9-987a-4a11-8013-9c9058bc800c)
![04_list_view_tab](https://github.com/user-attachments/assets/c9a4ee0b-e442-4119-8e4e-6535ad832bae)
![5_cms_page](https://github.com/user-attachments/assets/2ebfad1c-a106-4694-b03f-ba77d1795224)
![6_admin_product_edit](https://github.com/user-attachments/assets/bcea416e-1556-44cd-a5b8-cea4f0538925)
![6_admin_product_edit_1](https://github.com/user-attachments/assets/5d06e435-fb70-4720-a58c-4c0b8ee19fd0)
![7_admin_product_edit_2](https://github.com/user-attachments/assets/04125e15-571b-4cc4-a436-a2317230d1e4)
![9_admin_grid](https://github.com/user-attachments/assets/b1830d88-9b6f-4f4a-a849-01935b04fa58)
![10_admin_attachment_edit_1_updated](https://github.com/user-attachments/assets/a4d5a97b-e970-41a0-9bb3-c42f189f7405)
![10_admin_attachment_edit_1](https://github.com/user-attachments/assets/50026bb8-d009-45dd-b56c-0d801a45e017)
![11_admin_attachment_edit_2](https://github.com/user-attachments/assets/bea4c4d6-1365-46ef-bd45-757d392fb1f4)
![12_admin_attachment_edit_product](https://github.com/user-attachments/assets/3fda36a4-afd5-45e9-aa43-a582c30a130d)
![14_configuration_1](https://github.com/user-attachments/assets/ff1eec20-f3cf-46a2-8ac5-9ba5b46961d5)
![15_configuration_import_export](https://github.com/user-attachments/assets/a4883157-da07-4776-8040-819eb0e9ac15)
![16_configuration_block](https://github.com/user-attachments/assets/ba5d3085-c01d-4f41-9f0f-8ca0f91734ba)

