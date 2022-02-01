
  <?php
    require 'Includes/dbh.inc.php';
  ?>

  <!DOCTYPE html>
    <html>
    <head>
      <title>Tradersheet.io</title>
      <link rel="icon" type="image/png" href="icons/favicon.png"/>
      <meta charset="utf-8">
      <meta name=viewport content="width=device-width, initial-scale=1">
      <link type="text/css" href="scrollbars/css/OverlayScrollbars.css" rel="stylesheet"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <link rel="stylesheet/less" type="text/css" href="css/styles.less">
      <link rel="stylesheet/less" type="text/css" href="css/forms.less">
      <link rel="stylesheet/less" type="text/css" href="css/widgets.less">
      <link rel="stylesheet/less" type="text/css" href="css/dataColumns.less">
      <link rel="stylesheet/less" type="text/css" href="css/mobile.less">
      <link rel="stylesheet/less" type="text/css" href="css/apiDocs.less">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
      <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;700&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Noticia+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="nice-select/css/nice-select.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      <script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous">
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js" ></script>
      <script
        src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"
        integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk="
        crossorigin="anonymous">
      </script>
      <script type="text/javascript" src="scrollbars/js/jquery.overlayScrollbars.js"></script>
      <!--<script src="https://kit.fontawesome.com/1eb8c39439.js" crossorigin="anonymous"></script>-->
      <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
      <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
      <script src="textarea_autogrow/dist/jquery.ns-autogrow.js"></script>
      <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
      <script src="nice-select/js/jquery.nice-select.js"></script>
      <script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>

      <!-- Global site tag (gtag.js) - Google Analytics -->
      <?php if ($_SERVER['REMOTE_ADDR'] !== '::1' && $_SERVER['REMOTE_ADDR'] !== '127.0.0.1') : ?>
      <script async src="https://www.googletagmanager.com/gtag/js?id=G-29HN4J54FH"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-29HN4J54FH');
      </script>
      <?php endif ; ?>

    </head>
      <body style="font-family: 'Roboto', sans-serif; background: #000; overflow: hidden;">
