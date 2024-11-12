<!-- resources/views/design/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Design</title>
    <link rel="stylesheet" type="text/css" href="css/FancyProductDesigner.min.css" />
    <script src="js/fabric-5.3.1.min.js" type="text/javascript"></script>
    <script src="js/FancyProductDesigner.min.js" type="text/javascript"></script>

</head>
<body>
    <div id="fpd-container"></div>


    <script>
        // Initialize Fancy Product Designer
        var fpd = new FancyProductDesigner({
            el: 'fpd-container',
            // Add any additional configuration options here
        });
    </script>
</body>
</html>
