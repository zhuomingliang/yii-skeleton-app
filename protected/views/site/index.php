
<?php
$this->beginWidget('system.web.widgets.CMarkdown');
?>
# Yii Skeleton Application
Note: Usually requires nightly build of Yii

### Features:

* User management
     1. Login/logout
     2. Registration
     3. Email verification
     4. Administrative functions
     5. User list (using ajax pagination)
     6. User recovery 
* User groups
     1. Group authorization 
* Extensions
     1. Email
     2. Time Helper
     3. Logable Behavior
     4. Parse Cache Behavior 
* Extended access control (or rather simplified)
* Contact page
* Logging and clean urls configured 

### Checklist for installing:

* Edit paths in index.php as necessary
* Set up database in the main.php config file
* Run sql in the protected/config/tables.sql
* Optionally load mysql test data in protected/config/
* Login as admin with usrname=admin, password=admin 

## Links
* [Yii Forum Thread](http://www.yiiframework.com/forum/index.php/topic,799.0.html)
* [SVN at google code](http://code.google.com/p/yii-skeleton-app/)
<?php $this->endWidget(); ?>