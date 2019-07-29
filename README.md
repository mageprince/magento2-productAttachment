# Download Latest Module with Magento 2.3.x support From Magento Marketplace
# <a href="https://marketplace.magento.com/prince-module-productattachment.html">Download Link</a>

# Magento2 Product Attachment

The Product Attachments extension for Magento 2 equips product pages with a special attachments block where you can upload numerous documents such as user guides, extra images, pdf, certificates, licenses and many others. 

It also has API support SOAP and REST for creating,updating,deleting and get attachments. It also has support for get product API to get attachments by product.

<b>For Manage Attachment/Icon: Catalog->Product Attachments</b>

<b>For Settings: Stores->Configuration->MagePrince->Product Attachment</b>

# Screenshot

<h3>Product Page</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/prduct-view-page.png" alt="Product Page">

<h3>Attachment Admin Grid</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/2-admin-grid.png" alt="Attachment Admin Grid" />

<h3>Add/Edit Attachment</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/1-add-edit-attachment.png" alt="Add-Edit Attachment" />

<h3>Select Products</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/3-select-products.png" alt="Select Products On Add-Edit Attachment" />

<h3>Attachment Settings</h3>
<img src="https://raw.githubusercontent.com/mageprince/all-module-screenshots/master/Product-Attahments/4-settings.png" alt="Attachment Settings" />

# API (REST) examples

### Create new attachment

**METHOD**: POST  
**URL**: http://< your store url >/rest/V1/productattach/addupdate
**BODY**:

(json encoded)
```
{
  "productattachTable": {
        "productAttachId": "0",
        "name": "testname",
        "description": "test desc",
        "file": "testfile.pdf",
        "url": "",
        "store": "0,1",
        "customerGroup": "0,1,2,3",
        "products": "1,2,3",
        "active": "1"
  },
  "filename": "testfile.pdf",
  "fileContent": "JVBERi0xLjYNJeLjz9MN....CiUlRU9GDQo="
}
```

### Update attachment

(json encoded)
```
{
  "productattachTable": {
        "productAttachId": "10",
        "name": "testname",
        "description": "test desc",
  },
  "filename": "",
  "fileContent": ""
}

Note: Keep only field which you want to update except "filename" and "fileContent"

### Deleting an attachment record

**METHOD**: DELETE  
**URL**: http://< your store url >/rest/V1/productattach/delete/< attachment id >


# API (SOAP) examples

**Creating a new attachment record**

    <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:all="http://magetest:8000/index.php/soap/all?services=princeProductattachV1">
       <soap:Header/>
       <soap:Body>
          <all:princeProductattachV1UpdateInsertAttachmentRequest>
             <productattachTable>
                <productAttachId>0</productAttachId>
                <name>testname</name>
                <description>test desc</description>
                <file>testfile.pdf</file>
                <url></url>
                <store>0,1</store>
                <customerGroup>0,1,2,3</customerGroup>
                <products>1</products>
                <active>1</active>
             </productattachTable>
             <filename>testfile.pdf</filename>
             <fileContent><![CDATA[JVBERi0xLjYNJeLjz9MN....CiUlRU9GDQo=]]></fileContent>
          </all:princeProductattachV1UpdateInsertAttachmentRequest>
       </soap:Body>
    </soap:Envelope>

**Updating an attachment record** (same as the previous one, except for the given id in the productAttachId element)

    <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:all="http://magetest:8000/index.php/soap/all?services=princeProductattachV1">
       <soap:Header/>
       <soap:Body>
          <all:princeProductattachV1UpdateInsertAttachmentRequest>
             <productattachTable>
                <productAttachId>9</productAttachId>
                <name>testname</name>
                <description>test desc</description>
                <file>testfile.pdf</file>
                <url></url>
                <store>0,1</store>
                <customerGroup>0,1,2,3</customerGroup>
                <products>1</products>
                <active>1</active>
             </productattachTable>
             <filename>testfile.pdf</filename>
             <fileContent><![CDATA[JVBERi0xLjYNJeLjz9MN....CiUlRU9GDQo=]]></fileContent>
          </all:princeProductattachV1UpdateInsertAttachmentRequest>
       </soap:Body>
    </soap:Envelope>

**Deleting an attachment record**

    <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:all="http://magetest:8000/index.php/soap/all?services=princeProductattachV1">
       <soap:Header/>
       <soap:Body>
          <all:princeProductattachV1DeleteAttachmentRequest>
             <int>9</int>
          </all:princeProductattachV1DeleteAttachmentRequest>
       </soap:Body>
    </soap:Envelope>
