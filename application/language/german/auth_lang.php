<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - german
*
* Author: Ben Edmunds
* 		    ben.edmunds@gmail.com
*         @benedmunds
*
* Translation: Benjamin Neu (benny@duxu.de), Max Vogl mail@max-vogl.de
*
*
* Location: https://github.com/benedmunds/CodeIgniter-Ion-Auth
*
* Created:  29.07.2013
* Last-Edit: 23.04.2016
*
* Description:  german language file for Ion Auth example views
* Beschreibung:  Deutsche Sprach-Datei für Ion Auth Beispielansichten
*
*/

// Errors
$lang['error_csrf'] = 'Dieses Formular hat unsere Sicherheitskontrollen nicht bestanden.';

// Login
$lang['login_heading']         = 'Anmelden';
$lang['login_subheading']      = 'Bitte melden Sie sich mit Ihren Zungangsdaten an.';
$lang['login_identity_label']  = 'E-Mail/Benutzername:';
$lang['login_password_label']  = 'Kennwort:';
$lang['login_remember_label']  = 'Angemeldet bleiben:';
$lang['login_submit_btn']      = 'Anmelden';
$lang['login_forgot_password'] = 'Kennwort vergessen?';

// Index
$lang['index_heading']           = 'Benutzerverwaltung';
$lang['index_subheading']        = 'Übersicht aller registrierten Benutzer.';
$lang['index_fname_th']          = 'Vorname';
$lang['index_lname_th']          = 'Nachname';
$lang['index_email_th']          = 'E-Mail';
$lang['index_groups_th']         = 'Gruppen';
$lang['index_status_th']         = 'Status';
$lang['index_action_th']         = 'Aktion';
$lang['index_active_link']       = 'Aktiv';
$lang['index_inactive_link']     = 'Inaktiv';
$lang['index_inactive_link']     = 'Inaktiv';
$lang['index_create_user_link']  = 'Einen neuen Benutzer anlegen';
$lang['index_create_group_link'] = 'Eine neue Gruppe anlegen';

// Deactivate User
$lang['deactivate_heading']                  = 'Benutzer deaktivieren';
$lang['deactivate_subheading']               = 'Sind Sie sicher, dass Sie den Benutzer \'%s\' deaktivieren möchten?';
$lang['deactivate_confirm_y_label']          = 'Ja:';
$lang['deactivate_confirm_n_label']          = 'Nein:';
$lang['deactivate_submit_btn']               = 'Bestätigen';
$lang['deactivate_validation_confirm_label'] = 'Bestätigen';
$lang['deactivate_validation_user_id_label'] = 'Benutzer-ID';

// Create User
$lang['create_user_heading']                           = 'Benutzer anlegen';
$lang['create_user_subheading']                        = 'Bitte geben Sie die Daten des neuen Benutzers ein.';
$lang['create_user_fname_label']                       = 'Vorname:';
$lang['create_user_lname_label']                       = 'Nachname:';
$lang['create_user_identity_label']                    = 'Benutzername:';
$lang['create_user_company_label']                     = 'Firma:';
$lang['create_user_email_label']                       = 'E-Mail:';
$lang['create_user_phone_label']                       = 'Telefon:';
$lang['create_user_password_label']                    = 'Kennwort:';
$lang['create_user_password_confirm_label']            = 'Kennwort bestätigen:';
$lang['create_user_submit_btn']                        = 'Benutzer anlegen';
$lang['create_user_validation_fname_label']            = 'Vorname';
$lang['create_user_validation_lname_label']            = 'Nachname';
$lang['create_user_validation_identity_label']         = 'Benutzername';
$lang['create_user_validation_email_label']            = 'E-Mail';
$lang['create_user_validation_phone_label']            = 'Telefon';
$lang['create_user_validation_company_label']          = 'Firma';
$lang['create_user_validation_password_label']         = 'Kennwort';
$lang['create_user_validation_password_confirm_label'] = 'Kennwortbestätigung';

// Edit User
$lang['edit_user_heading']                           = 'Benutzer bearbeiten';
$lang['edit_user_subheading']                        = 'Bitte geben Sie die Daten des Benutzer ein.';
$lang['edit_user_fname_label']                       = 'Vorname:';
$lang['edit_user_lname_label']                       = 'Nachname:';
$lang['edit_user_company_label']                     = 'Firma:';
$lang['edit_user_email_label']                       = 'E-Mail:';
$lang['edit_user_phone_label']                       = 'Telefon:';
$lang['edit_user_password_label']                    = 'Kennwort: (falls geändert)';
$lang['edit_user_password_confirm_label']            = 'Kennwort bestätigen: (falls geändert)';
$lang['edit_user_groups_heading']                    = 'Mitglied folgender Gruppen';
$lang['edit_user_submit_btn']                        = 'Benutzerdaten speichern';
$lang['edit_user_validation_fname_label']            = 'Vorname';
$lang['edit_user_validation_lname_label']            = 'Nachname';
$lang['edit_user_validation_email_label']            = 'E-Mail';
$lang['edit_user_validation_phone_label']            = 'Telefon';
$lang['edit_user_validation_company_label']          = 'Firma';
$lang['edit_user_validation_groups_label']           = 'Gruppen';
$lang['edit_user_validation_password_label']         = 'Kennwort';
$lang['edit_user_validation_password_confirm_label'] = 'Kennwort bestätigen';

// Create Group
$lang['create_group_title']                  = 'Gruppe anlegen';
$lang['create_group_heading']                = 'Gruppe anlegen';
$lang['create_group_subheading']             = 'Bitte geben Sie die Daten der neuen Gruppe ein.';
$lang['create_group_name_label']             = 'Gruppenname:';
$lang['create_group_desc_label']             = 'Beschreibung:';
$lang['create_group_submit_btn']             = 'Gruppe anlegen';
$lang['create_group_validation_name_label']  = 'Gruppenname';
$lang['create_group_validation_desc_label']  = 'Beschreibung';

// Edit Group
$lang['edit_group_title']                  = 'Gruppe bearbeiten';
$lang['edit_group_saved']                  = 'Gruppe gespeichert';
$lang['edit_group_heading']                = 'Gruppe bearbeiten';
$lang['edit_group_subheading']             = 'Bitte geben Sie die Daten der neuen Gruppe ein.';
$lang['edit_group_name_label']             = 'Gruppenname:';
$lang['edit_group_desc_label']             = 'Beschreibung:';
$lang['edit_group_submit_btn']             = 'Gruppe speichern';
$lang['edit_group_validation_name_label']  = 'Gruppenname';
$lang['edit_group_validation_desc_label']  = 'Beschreibung';

// Change Password
$lang['change_password_heading']                               = 'Kennwort ändern';
$lang['change_password_old_password_label']                    = 'Altes Kennwort:';
$lang['change_password_new_password_label']                    = 'Neues Kennwort (mindestens %s Zeichen lang):';
$lang['change_password_new_password_confirm_label']            = 'Neues Kennwort bestätigen:';
$lang['change_password_submit_btn']                            = 'Ändern';
$lang['change_password_validation_old_password_label']         = 'Altes Kennwort';
$lang['change_password_validation_new_password_label']         = 'Neues Kennwort';
$lang['change_password_validation_new_password_confirm_label'] = 'Neues Kennwort bestätigen';

// Forgot Password
$lang['forgot_password_heading']                 = 'Kennwort vergessen';
$lang['forgot_password_subheading']              = 'Bitte geben Sie Ihre %s ein, damit wir Ihnen eine E-Mail schicken können, um das Kennwort zu ändern.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Absenden';
$lang['forgot_password_validation_email_label']  = 'E-Mail';
$lang['forgot_password_identity_label']          = 'Benutzername';
$lang['forgot_password_email_identity_label']    = 'E-Mail';
$lang['forgot_password_email_not_found']         = 'Kein Eintrag für diese E-Mail-Adresse gefunden.';
$lang['forgot_password_identity_not_found']      = 'Kein Eintrag für diesen Benutzernamen gefunden.';


// Reset Password
$lang['reset_password_heading']                               = 'Kennwort ändern';
$lang['reset_password_new_password_label']                    = 'Neues Kennwort (mindestens %s Zeichen lang):';
$lang['reset_password_new_password_confirm_label']            = 'Neues Kennwort bestätigen:';
$lang['reset_password_submit_btn']                            = 'Kennwort ändern';
$lang['reset_password_validation_new_password_label']         = 'Neues Kennwort';
$lang['reset_password_validation_new_password_confirm_label'] = 'Neues Kennwort bestätigen';

// Activation Email
$lang['email_activate_heading']    = 'Konto für %s aktivieren';
$lang['email_activate_subheading'] = 'Bitte klicken Sie auf diesen Link, um Ihr Konto zu %s';
$lang['email_activate_link']       = 'aktivieren';

// Forgot Password Email
$lang['email_forgot_password_heading']    = 'Kennwort für %s zurücksetzen';
$lang['email_forgot_password_subheading'] = 'Sie können Ihr Passwort über diesen Link %s.';
$lang['email_forgot_password_link']       = 'zurücksetzen';

