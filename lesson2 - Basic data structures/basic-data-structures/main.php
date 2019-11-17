<?php

require "bootstrap.php";


use OtusAlgorithms\DynamicArrayPerformanceTester as PerformanceTester;


echo (new PerformanceTester())->renderTestResultsTable();

