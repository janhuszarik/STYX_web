<html>
<body>
    <h2>Aktivácia konta na <?=NAME?></h2>
    <p><?php echo 'Vitajte! sme radi, že ste sa u nás registrovali. '; ?></p>
    <p>Stačí už len aktivovať účet kliknutím na následujúci link:</p>
    <!--	<h3>--><?php //echo sprintf(lang('email_activate_heading'), $identity);?><!--</h3>-->
    <p>Prihlasovacie meno a zároveň Váš registračný E-mail je: <?php echo $identity; ?></p>
	<p style="padding: 20px; text-align: center; border: 1px silver solid; font-size: 1.6em; ">
    <?php echo sprintf(lang('email_activate_subheading'), anchor('auth/activate/'. $id .'/'. $activation, lang('email_activate_link')));?>
    </p>



</body>
</html>