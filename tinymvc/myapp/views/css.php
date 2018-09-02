<?php header('Content-Type: text/css'); ?>
* {
    border: none;
    padding: 0;
    margin: 0;
}

body {
    background: #9dbde1 url(<?php echo $webroot; ?>/images/bg-gradient.gif) top repeat-x;
    color: #666666;
    font-family: arial,sans;
    font-size: 100%;
    margin: 0 auto;
    width: 900px;
    text-align: center;
}

.clr {
    clear: both;
}

.navigation {
    border: 1px solid black;
    background-color: #e0e0e0;
    margin: 3px auto;
    display: table;
    font-size: 0.9em;
    padding-top: 4px;
    padding-bottom: 4px;
}

.navigation ul {
    display: inline;
}

.navigation ul li {
    list-style: none;
    padding-top: 4px;
    padding-bottom: 4px;
    display: inline;
}

.navigation ul li.first {
    border-right: 1px solid #999999;
    font-weight: bold;
    padding-right: 8px;
    padding-left: 8px;
}

.navigation ul.admin li.first, .navigation ul.vote li.first {
    border-right: none;
    border-left: 1px solid #999999;
    font-weight: normal;
    padding-right: 0;
    padding-left: 0;
}

.navigation a {
    padding: 4px;
    padding-left: 8px;
    padding-right: 8px;
    text-decoration: none;
    color: blue;
}

.navigation a:hover {
    background-color: white;
    color: red;
}

div.message {
    width: 100%;
    margin: 3px auto;
    line-height: 1.7em;
}

div.confirm {
    background-color: yellow;
    border: 1px solid black;
}

img.thumbnail {
    margin: 2px;
    vertical-align: middle;
}

.self {
    border: 2px solid yellow;
}

img.edgefirst {
    margin-right: 0;
    border-right: none;
    white-space: nowrap;
}

img.edgelast {
    margin-left: 0;
    border-left: none;
    white-space: nowrap;
}

img.frame {
    border: 1px solid black;
}

h2 {
    margin-top: 30px;
    border-bottom: 1px solid #666666;
    text-align: left;
    padding-bottom: 5px;
    margin-bottom: 5px;
}

pre {
    text-align: left;
    line-height: 1em;
    border: 1px dashed; #666666;
    background-color: white;
    padding: 10px;
    font-size: 90%;
    overflow: scroll;
    width: 800px;
    height: 600px;
    margin-left: auto;
    margin-right: auto;
}


table {
    margin-left: auto;
    margin-right: auto;
}

th {
    padding-left: 5px;
    padding-right: 5px;
}

td {
    padding: 5px;
}

div.admin {
    background-color: #ffffcc;
    border: 1px solid black;
    margin: 10px;
    padding: 5px;
    width: 350px;
    margin-left: auto;
    margin-right: auto;
}

input[type=text] {
    border: 1px solid #666666;
}

input[type=password] {
    border: 1px solid #666666;
}

table.config {
    text-align: left;
}

table.config .pass {
    color: green;
}

table.config .fail {
    color: red;
}

span.filename {
    color: blue;
}

span.album {
    border: 1px solid black;
    width: 100px;
    height: 100px;
    display: inline-block;
    margin: 10px;
}

span.thumb {
    border: 1px solid black;
    width: 100px;
    height: 100px;
    display: inline-block;
    margin: 10px;
    overflow: hidden;
}
