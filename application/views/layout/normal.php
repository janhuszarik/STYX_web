<?php
    /**
     * Project STYX
     * User: Jan Huszarik
     * Copyright: Jan Huszarik
     * Date: 1.7.2024
     * Time: 17:24
     * mail: jan.huszarik@styx.at
     */


    require_once('header.php');

//	require_once('cookies.php');

    require_once('menu.php');

	require_once('slider.php');

	$this->load->view($page);

    require_once('footer.php');

