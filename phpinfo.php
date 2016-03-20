<!DOCTYPE html>
<html>
<head>
    <title>phpinfo</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style type="text/css">
        body {font-family: "Ubuntu Mono", "Monospace", "Monaco", "Courier New"; font-size: 12px; padding-top: 70px}
        th, td {padding: 15px; text-align: center; border-collapse: collapse}
        tbody {display: table; width: 100%}
        table {border-collapse: collapse}
        table, th, td {border: 1px solid #8892bf}
        /* Search */
        .results tr[visible='false'] {display:none}
        .results tr[visible='true'] {display:table-row}
        /* Bootstrap */
        .navbar-default {background-color: #8892bf; border-color: #4f5b93}
        .navbar-default .navbar-brand {color: #ecf0f1}
        .navbar-default .navbar-brand:hover,
        .navbar-default .navbar-brand:focus {color: #ecdbff}
        .navbar-default .navbar-text {color: #ecf0f1}
        .navbar-default .navbar-nav > li > a {color: #ecf0f1}
        .navbar-default .navbar-nav > li > a:hover,
        .navbar-default .navbar-nav > li > a:focus {color: #ecdbff}
        .navbar-default .navbar-nav > .active > a,
        .navbar-default .navbar-nav > .active > a:hover,
        .navbar-default .navbar-nav > .active > a:focus {color: #ecdbff; background-color: #4f5b93}
        .navbar-default .navbar-nav > .open > a,
        .navbar-default .navbar-nav > .open > a:hover,
        .navbar-default .navbar-nav > .open > a:focus {color: #ecdbff; background-color: #4f5b93}
        .navbar-default .navbar-toggle {border-color: #4f5b93}
        .navbar-default .navbar-toggle:hover,
        .navbar-default .navbar-toggle:focus {background-color: #4f5b93}
        .navbar-default .navbar-toggle .icon-bar {background-color: #ecf0f1}
        .navbar-default .navbar-collapse,
        .navbar-default .navbar-form {border-color: #ecf0f1}
        .navbar-default .navbar-link {color: #ecf0f1}
        .navbar-default .navbar-link:hover {color: #ecdbff}

        @media (max-width: 767px) {
            .navbar-default .navbar-nav .open .dropdown-menu > li > a {color: #ecf0f1}
            .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
            .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {color: #ecdbff}
            .navbar-default .navbar-nav .open .dropdown-menu > .active > a,
            .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
            .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {color: #ecdbff;background-color: #4f5b93}
        }
    </style>
    <link rel="shortcut icon" href="http://php.net/favicon.ico" type="image/x-icon" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
        function phpinfo_array() {
            ob_start();
            phpinfo();
            $info_arr = array();
            $info_lines = explode("\n", strip_tags(ob_get_clean(), "<tr><td><h2>"));
            $cat = "General";
            foreach($info_lines as $line) {
                preg_match("~<h2>(.*)</h2>~", $line, $title) ? $cat = $title[1] : null;
                if(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val)) {
                    $info_arr[$cat][$val[1]] = $val[2];
                } elseif(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val)) {
                    $info_arr[$cat][$val[1]] = array("local" => $val[2], "master" => $val[3]);
                }
            }
            return $info_arr;
        }

        function myprint_r($my_array) {
            if (is_array($my_array)) {
                echo '<table border=1px cellspacing=0 cellpadding=3 class="results" style="display:block;max-width:100%;table-layout:fixed;">';
                echo '<tr><td colspan=2 style="background-color:#8892BF;height:10px;"><strong><font color=white></font></strong></td></tr>';
                foreach ($my_array as $k => $v) {
                        echo '<tr><td valign="top" style="word-wrap:break-word;background-color:#F0F0F0;">';
                        echo '<strong>' . $k . '</strong></td><td style="word-wrap:break-word;">';
                        myprint_r($v);
                        echo "</td></tr>";
                }
                echo "</table>";
                return;
            }
            $pattern = ',';
            $replace = ', ';
            $my_array = preg_replace("/,([^\s])/", ", $1", $my_array);
            echo $my_array;
        }
    ?>
    
    <nav class="navbar navbar-inverse navbar-fixed-top navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="http://php.net/favicon.ico" alt="">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Projects</a>
                    </li>
                    <li>
                        <a href="#">phpinfo</a>
                    </li>
                    <li>
                        <a href="#">About</a>
                    </li>
                </ul>
                <div class="col-sm-3 col-md-2 pull-right">
                    <div class="input-group navbar-form">
                        <input type="text" class="form-control search" placeholder="Search">
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="container" style="padding-bottom: 25px;">
        <div class="row">
            <div class="col-lg-12">
                <?php echo myprint_r(phpinfo_array()); ?>
            </div>
        </div>
    </div>
    
</body>
</html>

<script>
    $(document).ready(function() {
        $(".search").keyup(function () {
            var searchTerm = $(".search").val();
            var listItem = $('.results strong').children('tr');
            var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

            $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
                return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
            }
            });

            $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
                $(this).attr('visible','false');
            });

            $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
                $(this).attr('visible','true');
            });

            var jobCount = $('.results tbody tr[visible="true"]').length;
            $('.counter').text(jobCount + ' item');

            if(jobCount == '0') {$('.no-result').show();}
            else {$('.no-result').hide();}
        });
    });
</script>
