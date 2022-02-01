<?php

    session_start();

    if (isset($_SESSION['uid'])) {
        require 'dbh.inc.php';

        $symbol = $_POST['symbol'];

        $stmt = $conn->prepare('SELECT alphavantage_apikey FROM users WHERE uid=?');
        $stmt->bind_param('i', $_SESSION['uid']);
        $stmt->execute();
        $stmt->bind_result($key);
        $stmt->fetch();

        echo '<div class="tradeInfoInner">';

        echo '
        <div class="tradingViewChartWidget">
        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container">
          <div id="tradingview_73bb4"></div>
          <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/" rel="noopener" target="_blank"><span class="blue-text">AAPL Chart</span></a> by TradingView</div>
          <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
          <script type="text/javascript">
          new TradingView.widget(
          {
          "width": "100%",
          "height": "100%",
          "symbol": "'.$symbol.'",
          "interval": "D",
          "timezone": "Etc/UTC",
          "theme": "dark",
          "style": "1",
          "locale": "en",
          "toolbar_bg": "#f1f3f6",
          "details" : "true",
          "enable_publishing": false,
          "allow_symbol_change": true,
          "container_id": "tradingview_73bb4"
        }
          );
          </script>
        </div>
        <!-- TradingView Widget END -->
        </div>
        ';

        echo '</div>';
        
    }