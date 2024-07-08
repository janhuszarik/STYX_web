<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - Slovak
*
* Author: Jakub Vatrt
* 		  vatrtj@gmail.com
*
*
* Created:  11.11.2016
*
* Description:  Slovak language file for Ion Auth messages and errors
*
*/

// Account Creation
// Account Creation
$lang['account_creation_successful'] = 'Konto wurde erfolgreich erstellt';
$lang['account_creation_unsuccessful'] = 'Konto konnte nicht erstellt werden';
$lang['account_creation_duplicate_email'] = 'E-Mail existiert bereits oder ist ungültig';
$lang['account_creation_duplicate_identity'] = 'Benutzername existiert bereits oder ist ungültig';

// TODO Please Translate
$lang['account_creation_missing_default_group'] = 'Standardgruppe nicht festgelegt';
$lang['account_creation_invalid_default_group'] = 'Ungültiger Gruppenname';

// Password
$lang['password_change_successful'] = 'Passwort wurde erfolgreich geändert';
$lang['password_change_unsuccessful'] = 'Passwort konnte nicht geändert werden';
$lang['forgot_password_successful'] = 'Das Passwort wurde per E-Mail gesendet';
$lang['forgot_password_unsuccessful'] = 'Passwort konnte nicht zurückgesetzt werden';

// Activation
$lang['activate_successful'] = 'Konto wurde aktiviert';
$lang['activate_unsuccessful'] = 'Konto konnte nicht aktiviert werden';
$lang['deactivate_successful'] = 'Konto wurde deaktiviert';
$lang['deactivate_unsuccessful'] = 'Konto konnte nicht deaktiviert werden';
$lang['activation_email_successful'] = 'Aktivierungsemail wurde gesendet';
$lang['activation_email_unsuccessful'] = 'Aktivierungsemail konnte nicht gesendet werden';
$lang['deactivate_current_user_unsuccessful'] = 'Sie können sich nicht selbst deaktivieren.';

// Login / Logout
$lang['login_successful'] = 'Erfolgreich angemeldet';
$lang['login_unsuccessful'] = 'Ungültige E-Mail oder Passwort';
$lang['login_unsuccessful_not_active'] = 'Konto ist nicht aktiv';
$lang['login_timeout'] = 'Vorübergehend gesperrt aus Sicherheitsgründen. Versuchen Sie es später';
$lang['logout_successful'] = 'Erfolgreich abgemeldet';

// Account Changes
$lang['update_successful'] = 'Kontoinformationen wurden erfolgreich aktualisiert';
$lang['update_unsuccessful'] = 'Kontoinformationen konnten nicht aktualisiert werden';
$lang['delete_successful'] = 'Benutzer wurde gelöscht';
$lang['delete_unsuccessful'] = 'Benutzer konnte nicht gelöscht werden';

// Groups
$lang['group_creation_successful'] = 'Gruppe wurde erfolgreich erstellt';
$lang['group_already_exists'] = 'Gruppenname existiert bereits';
$lang['group_update_successful'] = 'Gruppendetails wurden aktualisiert';
$lang['group_delete_successful'] = 'Gruppe wurde gelöscht';
$lang['group_delete_unsuccessful'] = 'Gruppe konnte nicht gelöscht werden';
$lang['group_delete_notallowed'] = 'Administratorengruppe kann nicht gelöscht werden';
$lang['group_name_required'] = 'Gruppenname ist ein Pflichtfeld';
$lang['group_name_admin_not_alter'] = 'Der Gruppenname der Administratorgruppe kann nicht geändert werden';

// Activation Email
$lang['email_activation_subject'] = 'Kontoaktivierung';
$lang['email_activate_heading'] = 'Aktivieren Sie Ihr Konto bei %s';
$lang['email_activate_subheading'] = 'Bitte klicken Sie auf folgenden Link für %s.';
$lang['email_activate_link'] = 'Aktivieren Sie Ihr Konto';
// Forgot Password Email
$lang['email_forgotten_password_subject'] = 'Passwort-Wiederherstellungskontrolle';
$lang['email_forgot_password_heading'] = 'Passwort-Wiederherstellung für %s';
$lang['email_forgot_password_subheading'] = 'Bitte klicken Sie auf folgenden Link für %s.';
$lang['email_forgot_password_link'] = 'Setzen Sie Ihr Passwort zurück';

$lang['form_validation_required']              = 'Das Feld {field} ist erforderlich.';
$lang['form_validation_isset']                 = 'Das Feld {field} muss einen Wert haben.';
$lang['form_validation_valid_email']           = 'Das Feld {field} muss eine gültige E-Mail-Adresse enthalten.';
$lang['form_validation_valid_emails']          = 'Das Feld {field} muss alle gültigen E-Mail-Adressen enthalten.';
$lang['form_validation_valid_url']             = 'Das Feld {field} muss eine gültige URL enthalten.';
$lang['form_validation_valid_ip']              = 'Das Feld {field} muss eine gültige IP-Adresse enthalten.';
$lang['form_validation_valid_base64']          = 'Das Feld {field} muss eine gültige Base64-Zeichenkette enthalten.';
$lang['form_validation_min_length']            = 'Das Feld {field} muss mindestens {param} Zeichen lang sein.';
$lang['form_validation_max_length']            = 'Das Feld {field} darf nicht mehr als {param} Zeichen lang sein.';
$lang['form_validation_exact_length']          = 'Das Feld {field} muss genau {param} Zeichen lang sein.';
$lang['form_validation_alpha']                  = 'Das Feld {field} darf nur alphabetische Zeichen enthalten.';
$lang['form_validation_alpha_numeric']         = 'Das Feld {field} darf nur alphanumerische Zeichen enthalten.';
$lang['form_validation_alpha_numeric_spaces']  = 'Das Feld {field} darf nur alphanumerische Zeichen und Leerzeichen enthalten.';
$lang['form_validation_alpha_dash']            = 'Das Feld {field} darf nur alphanumerische Zeichen, Unterstriche und Bindestriche enthalten.';
$lang['form_validation_numeric']               = 'Das Feld {field} darf nur Zahlen enthalten.';
$lang['form_validation_is_numeric']            = 'Das Feld {field} darf nur numerische Zeichen enthalten.';
$lang['form_validation_integer']               = 'Das Feld {field} muss eine ganze Zahl enthalten.';
$lang['form_validation_regex_match']           = 'Das Feld {field} entspricht nicht dem richtigen Format.';
$lang['form_validation_matches']               = 'Das Feld {field} stimmt nicht mit dem Feld {param} überein.';
$lang['form_validation_differs']               = 'Das Feld {field} muss sich von dem Feld {param} unterscheiden.';
$lang['form_validation_is_unique']             = 'Das Feld {field} muss einen eindeutigen Wert enthalten.';
$lang['form_validation_is_natural']            = 'Das Feld {field} darf nur Ziffern enthalten.';
$lang['form_validation_is_natural_no_zero']    = 'Das Feld {field} darf nur Ziffern enthalten und muss größer als null sein.';
$lang['form_validation_decimal']               = 'Das Feld {field} muss eine Dezimalzahl enthalten.';
$lang['form_validation_less_than']             = 'Das Feld {field} muss eine Zahl kleiner als {param} enthalten.';
$lang['form_validation_less_than_equal_to']    = 'Das Feld {field} muss eine Zahl kleiner oder gleich {param} enthalten.';
$lang['form_validation_greater_than']          = 'Das Feld {field} muss eine Zahl größer als {param} enthalten.';
$lang['form_validation_greater_than_equal_to'] = 'Das Feld {field} muss eine Zahl größer oder gleich {param} enthalten.';
$lang['form_validation_error_message_not_set'] = 'Es konnte keine Fehlermeldung für Ihr Feld {field} gefunden werden.';
$lang['form_validation_in_list']               = 'Das Feld {field} muss einer der folgenden Werte sein: {param}.';


