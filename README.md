# Goblin - small & sneaky

Introducing the "Goblin" PHP framework, a lightweight and efficient tool designed to streamline the development process. 
With its small size and speedy performance, Goblin is adept at concealing file extensions and offers a format reminiscent of Express. 
Amazingly, it consists of only three files, making it a highly accessible and manageable option for web development projects.

## Example - index & error page

```
<?PHP // index.php
    include("goblin.php");
    goblin_route("", function($path){
        $pageTitle = "/ Home";
        include("_template.php");
    });
    goblin_route("*", function($path){
        $pageTitle = "/ Error 404";
        include("_template.php");
    });
?>
```

## Example - Serve Files

```
<?PHP // index.php
    include("goblin.php");
    goblin_route("css/*", function($path){ goblin_send_file('./html/'.$path); });
    goblin_route("img/*", function($path){ goblin_send_file('./html/'.$path); });
    goblin_route("", function($path){
        $pageTitle = "/ Home";
        include("_template.php");
    });
    goblin_route("*", function($path){
        $pageTitle = "/ Error";
        include("_template.php");
    });
?>
```

## Example - JSON API

```
<?PHP // index.php
    include("goblin.php");
    goblin_route("api", function($path){
        goblin_send_json(array(1,2,3,4,5,6));
    });
    goblin_route("", function($path){
        $pageTitle = "/ Home";
        include("_template.php");
    });
    goblin_route("*", function($path){
        $pageTitle = "/ Error";
        include("_template.php");
    });
?>
```
