# Magento2 Product Attachment

The Product Attachments extension for Magento 2 equips product pages with a special attachments block where you can upload numerous documents such as user guides, extra images, pdf, certificates, licenses and many others. 

It also has API support (SOAP) for creating/updating and deleting attachments.

<b>Magento Market Place Link:</b> https://marketplace.magento.com/prince-module-productattachment.html</b>

# Installation Instruction

- Copy the content of the repo to the <b>app/code/Prince/Productattach</b>
- Run command: <b>php bin/magento setup:upgrade</b>
- Run command: <b>php bin/magento setup:static-content:deploy</b>
- Now flush cache: <b>php bin/magento cache:flush</b>

# How to Change Attachment Icons

<b>Frontend Attachments Icons:</b>

You can find all frontend attachment icons from here `Prince\Productattach\view\frontend\web\images`
Just replace icon images with your icon image. Image file must be in png format.

<b>Admin Attachments Icons:</b>

You can find all admin attachment icons from here:`Prince\Productattach\view\adminhtml\web\images`
Just replace icon images with your icon image. Image file must be in png format.

<b>Run This Commands After changes icon images</b>

php bin/magento setup:static-content:deploy

php bin/magento cache:flush

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
    
# Contribution

Want to contribute to this extension? The quickest way is to <a href="https://help.github.com/articles/about-pull-requests/">open a pull request</a> on GitHub.

# Support

If you encounter any problems or bugs, please <a href="https://github.com/mageprince/magento2-productAttachment/issues">open an issue</a> on GitHub.
