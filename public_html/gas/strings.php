<?php
	include('errors_warnings.php');

    $index_submit_button = "Είσοδος";
    $index_question =  "Δεν έχετε λογαριασμό;";
    $index_signup_link = "Εγγραφή";
	
	$login_title = "Εισοδος στο Σύστημα";
	$login_error_empty = "Τα πεδία Όνομα Χρήστη και Κωδικός Πρόσβασης είναι υποχρεωτικά.";
	$login_error_active = "Ο λογαριασμός σας δεν είναι ενεργοποιημένος. Ελέγξτε τα email σας για μήνυμα με σύνδεσμο ενεργοποίησης.";
	$lorin_error_wrong = "Λάθος Όνομα Χρήστη ή Κωδικός Πρόσβασης!";
	
	$signup_header = "Δημιουργία Λογαριασμού";
	$signup_account_details = "Στοιχεία Λογαριασμού";
	$signup_username = "Όνομα Χρήστη *";
	$signup_email = "Email *";
	$signup_password = "Κωδικός Πρόσβασης *";
	$signup_repeat_password = "Επαλήθευση Κωδικού Πρόσβασης *";
	$signup_explain =  "* Υποχρεωτικά πεδία";
	$signup_personal_details = "Προσωπικές Πληροφορίες";
	$signup_name = "Όνομα *";
	$signup_surname = "Επώνυμο *";
	$signup_afm = "Α.Φ.Μ. *";
	$signup_phone1 = "Τηλέφωνο 1 *";
	$signup_phone2 = "Τηλέφωνο 2";
	$signup_address_details = "Στοιχεία Διέυθυνσης";
	$signup_address = "Διεύθυνση";
	$signup_number = "Αριθμός";
	$signup_postcode = "Τ.Κ.";
	$signup_city = "Πόλη";
	$signup_country = "Χώρα";
	$signup_greece = "Ελλάδα";
	$signup_cyprus = "Κύπρος";
	$signup_submit_button = "Εγγραφή";
	$signup_success = "Η εγγραφή σας πραγματοποιήθηκε με επιτυχία! Θα λάβετε email ενεργοποίησης λογαριασμού.";
	$signup_error = "Η εγγραφή σας δεν πραγματοποιήθηκε.";
	$signup_error_pass = "Ο κωδικός πρόσβασης πρέπει να είναι ίδιος και στα δύο πεδία.";
	$signup_question = "Έχετε ήδη λογαριασμό;";
	$signup_index_link = "Συνδεθείτε";
	$signup_phone = "Σταθερό";
	$signup_cellphone = "Κινητό";
	$signup_msg1 = "Μόλις εγγραφήκατε στο Σύστημα Παροχής Τεχνικής Υποστήριξης iGasService. Παρακαλούμε ακολουθείστε τον παρακάτω σύνδεσμο για να ενεργοποιήσετε τον λογαριασμό σας: \r\n https://zafora.icte.uowm.gr/~ictest00446/gas/verify.php?email=";
	$signup_msg2 = "&hash=";
	$signup_msg3 = " . \r\n\r\n Στη συνέχεια, μπορέιτε να συνδεθείτε με τα παρακάτω στοιχεία: \r\n Όνομα Χρήστη: ";
	$signup_msg4 = " \r\n Κωδικός Πρόσβασης: ";
	$signup_subject = "Επιβεβαίωση Εγγραφής";
	
	$menu_title = "Βασικό Μενού";
	$menu_super = "διαχειριστής";
	$menu_technician = "τεχνικός";
	$menu_header = "Σύστημα Παροχής Τεχνικής Υποστήριξης iGasService";
	$menu_welcome = "Καλώς ήρθες ";
	$menu_exit_button = "Αποσύνδεση";
	$menu_calendar = "Ημερολογιο";
	$menu_calendar_text = "Διαχείρηση ραντεβού, προγραμματισμός χρόνου";
	$menu_notifications = "Ειδοποιησεις";
	$menu_notifications_text = "Υπενθυμίσεις για service, ανανέωση πιστοποιητικών";
	$menu_customers = "Πελατες";
	$menu_customers_text = "Αναζήτηση, προσθήκη, επεξεργασία, διαγραφή";
	$menu_tanks = "Δεξαμενες";
	$menu_tanks_text = "Αναζήτηση, προσθήκη, επεξεργασία, διαγραφή";
	$menu_technicians = "Τεχνικοι";
	$menu_technicians_text = "Αναζήτηση, επεξεργασία, διαγραφή";
	
	$copyright_developed = "© Developed by ";
	$copyright_myname = "Potsika Iliana";
	$copyright_supervised = " | Supervised by ";
	$copyright_mdname = "Minas Dasygenis";
	$copyright_university = "University of Western Macedonia";
	$copyright_column = " | ";
	$copyright_department = "Department of Informatics & Telecommunications Engineering";
	
	$logout_message = "Έχετε αποσυνδεθεί επιτυχώς! Περιμένετε...";
	
	$navbar_menu = "Μενού";
	$navbar_calendar = "Ημερολόγιο";
	$navbar_notifications = "Ειδοποιήσεις";
	$navbar_customers = "Πελάτες";
	$navbar_tanks = "Δεξαμενές";
	$navbar_technicians = "Τεχνικοί";
	
	$customers_header = "Πελατολόγιο";
	$customers_id = "ID";
	$customers_surname = "Επώνυμο";
	$customers_name = "Όνομα";
	$customers_afm = "Α.Φ.Μ";
	$customers_phone = "Τηλέφωνο";
	$customers_add = "Προσθήκη νέου πελάτη";
	$customers_delete = "Διαγραφή";
	$customers_edit = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επεξεργασία";
	$customers_profile = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Προφίλ";
	$customers_pass = "&nbsp;&nbsp;Αλλαγή Password";
	
	$add_customer_title = "Προσθήκη Πελάτη";
	$add_customer_header = "Προσθήκη Νέου Πελάτη";
	$add_customer_tank_details = "Στοιχεία Δεξαμενής";
	$add_customer_email = "Email";
	$add_customer_afm = "Α.Φ.Μ. *";
	$add_customer_tank = "Δεξαμενή *";
	$add_customer_tech = "Τεχνικός *";
	$add_customer_installation_date = "Ημερομηνία Εγκατάστασης ";
	$add_customer_certificate_expire = "Ημερομηνία Λήξης Πιστοποιητικού ";
	$add_customer_submit_button = "Προσθήκη";
	$add_customer_success = "Τα στοιχεία του νέου σας πελάτη αποθηκεύτηκαν.";
	$add_customer_error = "Σφάλμα! Τα στοιχεία του νέου σας πελάτη δεν αποθηκεύτηκαν.";
	
	$delete_customer_success = "Η διαγραφή πραγματοποιήθηκε με επιτυχία!";
	$delete_customer_error = "Σφάλμα! Η διαγραφή δεν πραγματοποιήθηκε.";
	
	$edit_customer_title = "Επεξεργασία Πελάτη";
	$edit_customer_header = "Επεξεργασία Στοιχείων Πελάτη";
	$edit_customer_submit_button = "Τροποποίηση";
	$edit_customer_success = "Οι αλλαγές αποθηκεύτηκαν. Περιμένετε...";
	$edit_customer_error = "Σφάλμα! Οι αλλαγές δεν αποθηκεύτηκαν. Περιμένετε...";
	
	$profile_customer_header = "Προφίλ Πελάτη";
	$profile_customer_event = "Κλείσε ραντεβού";
	$profile_customer_edit = "Επεξεργασία";
	$profile_customer_personal = "Προσωπικές Πληροφορίες";
	$profile_customer_communication = "Στοιχεία Επικοινωνίας";
	$profile_customer_logfile = "Aρχείο Kαταγραφής";
	$profile_customer_tank_details = "Στοιχεία Δεξαμενής";
	$profile_customer_add_appointment = "Προσθήκη ραντεβού";
	$profile_label_surname = "Επώνυμο:";
	$profile_label_name = "Όνομα:";
	$profile_label_afm = "Α.Φ.Μ.:";
	$profile_label_phone1 = "Τηλέφωνο 1:";
	$profile_label_phone2 = "Τηλέφωνο 2:";
	$profile_label_email = "Email:";
	$profile_label_address = "Διεύθυνση:";
	$profile_tank = "Δεξαμενή ";
	$profile_label_tank = "Μοντέλο:";
	$profile_label_installation_date = "Ημερομηνία Εγκατάστασης:";
	$profile_label_certificate_expire = "Ημερομηνία Λήξης Πιστοποιητικού:";
	$profile_label_tech_name = "Τεχνικός:";
	$profile_no_customer = "Δεν υπάρχει πελάτης με αυτό το ID.";
	
	$technicians_header = "Τεχνικοί";
	$technicians_add = "Προσθήκη νέου τεχνικού";
	
	$add_technician_title = "Προσθήκη Τεχνικού";
	$add_technician_header = "Προσθήκη Νέου Τεχνικού";
	$add_technician_success = "Τα στοιχεία του νέου τεχνικού αποθηκεύτηκαν και του έχει αποσταλεί ενημερωτικό email.";
	$add_technician_error = "Σφάλμα! Τα στοιχεία του νέου τεχνικού δεν αποθηκεύτηκαν.";
	$add_technician_error_pass = "Ο κωδικός πρόσβασης πρέπει να είναι ίδιος και στα δύο πεδία.";
	$add_technician_msg1 = "Μόλις πραγματοποιήθηκε η εγγραφή σας στο Σύστημα Διαχείρισης Πελατειακών Σχέσεων iGasService. Μπορείτε να συνδεθείτε στο σύστημα ακολουθώντας τον εξής σύνδεσμο:\r\n zafora.icte.uowm.gr/~ictest00446/gas . \r\n\r\n Όνομα Χρήστη: ";
	$add_technician_msg2 = " \r\n Κωδικός Πρόσβασης: ";
	$add_technician_msg3 = " \r\n\r\nΜπορείτε να αλλάξετε τον κωδικό πρόσβασης αφού εισέλθετε στο σύστημα.";
	$add_technician_subject="Καλώς ήρθατε στο iGasService";
		
	$edit_technician_title = "Επεξεργασία Τεχνικού";
	$edit_technician_header = "Επεξεργασία Στοιχείων Τεχνικού";
	$edit_technician_my = "Επεξεργασία του Προφίλ μου";
	$edit_technician_root = "Πληροφορίες Συστήματος";
	$edit_technician_type = "Τύπος Χρήστη *";
	$edit_technician_technician = "Τεχνικός";
	$edit_technician_admin = "Διαχειριστής";
	
	$profile_technician_header = "Προφίλ Τεχνικού";
	$profile_technician_my = "Το Προφίλ μου";
	$profile_technician_change_pass = " Αλλαγή Κωδικού Πρόσβασης";
	$profile_no_technician = "Δεν υπάρχει τεχνικός με αυτό το ID.";
	
	$change_password_header = "Αλλαγή Κωδικού Πρόσβασης";
	$change_password_old = "Παλιός Κωδικός *";
	$change_password_new1 = "Νέος Κωδικός *";
	$change_password_new2 = "Επαλήθευση <br> Νέου Κωδικού *";
	$change_password_success = "Ο κωδικός πρόσβασης άλλαξε! Περιμένετε...";
	$change_password_error = "Σφάλμα! Ο κωδικός πρόσβασης δεν άλλαξε.";
	$change_password_error_diff = "Σφάλμα! Δεν έγινε σωστή επαλήθευση του νέου κωδικού.";
	$change_password_error_old = "Σφάλμα! Ο παλιός κωδικός δεν είναι σωστός.";
	$change_password_submit_button = "Αλλαγή";
	$change_password_no_rights = "Δεν έχετε δικαίωμα να κάνετε αλλαγές γι' αυτόν τον χρήστη.";
	$change_password_msg1 = "Σύστημα Παροχής Τεχνικής Υποστήριξης iGasService: \r\nΟ κωδικός πρόσβασής σας έχει αλλάξει. Ο νέος κωδικός πρόσβασης που μπορείτε να χρησιμοποιήσετε για να συνδεθείτε στο σύστημα είναι: ";
	$change_password_msg2 = ". \r\n\r\nΣας παρακαλούμε, για την ασφάλεια των προσωπικών σας δεδομένων, να αλλάξετε τον κωδικό αυτό, αμέσως μόλις συνδεθείτε στο σύστημα.";
	$change_password_subject = "iGasService: Αλλαγή Κωδικού Πρόσβασης";
	
	$tanks_header = "Δεξαμενές";
	$tanks_model = "Μοντέλο";
	$tanks_fuel = "Καύσιμο";
	$tanks_manufacturer = "Κατασκευαστής";
	$tanks_placement = "Τοποθέτηση";
	$tanks_certificate_expire = "Λήξη Πιστοποιητικού";
	$tanks_add = "Προσθήκη Νέας Δεξαμενής";
	$tanks_upload = "Προσθήκη Αρχείων";
	$tanks_moreinfo = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Πληροφορίες";
	
	$add_tank_title = "Προσθήκη Δεξαμενής";
	$add_tank_header = "Προσθήκη Νέας Δεξαμενής";
	$add_tank_general = "Γενικά Χαρακτηριστικά";
	$add_tank_model = "Μοντέλο *";
	$add_tank_fuel = "Καύσιμο *";
	$add_tank_placement = "Τοποθέτηση *";
	$add_tank_wall = "επιτοίχιος";
	$add_tank_ground = "επιδαπέδιος";
	$add_tank_manufacturer = "Κατασκευαστής *";
	$add_tank_certificate_expire = "Λήξη Πιστοποιητικού: ";
	$add_tank_tech = "Τεχνικά Χαρακτηριστικά";
	$add_tank_heating = "Θερμαντική Ισχύς *";
	$add_tank_hotwater = "Ισχύς Ζεστού Νερού";
	$add_tank_maximum_input = "Μέγιστη Είσοδος Καύσιμου";
	$add_tank_power_supply = "Ηλεκτρική τροφοδοσία";
	$add_tank_dw = "Διαστάσεις & Βάρος";
	$add_tank_dimensions = "Διαστάσεις";
	$add_tank_weight = "Βάρος";
	$add_tank_chimney = "Διάμετρος Καπνοδόχου (mm):";
	$add_tank_chimney_in = "Τροφοδοσίας Αέρα";
	$add_tank_chimney_out = "Απόρριψης Καυσαερίων";
	$add_tank_success = "Τα στοιχεία της δεξαμενής αποθηκεύτηκαν.";
	$add_tank_error = "Σφάλμα! Τα στοιχεία της δεξαμενής δεν αποθηκεύτηκαν.";
	
	$edit_tank_title = "Επεξεργασία Δεξαμενής";
	$edit_tank_header = "Επεξεργασία Στοιχείων Δεξαμενής";
	
	$moreinfo_tank_header = "Πληροφορίες Δεξαμενής";
	$moreinfo_label_model = "Μοντέλο: ";
	$moreinfo_label_fuel = "Καύσιμο: ";
	$moreinfo_label_placement = "Τοποθέτηση: ";
	$moreinfo_label_manufacturer = "Κατασκευαστής: ";
	$moreinfo_label_heating = "Θερμαντική Ισχύς: ";
	$moreinfo_label_hotwater = "Ισχύς Ζεστού Νερού: ";
	$moreinfo_label_maximum_input = "Μέγιστη Είσοδος Καύσιμου: ";
	$moreinfo_label_power_supply = "Ηλεκτρική τροφοδοσία: ";
	$moreinfo_label_dimensions = "Διαστάσεις: ";
	$moreinfo_label_weight = "Βάρος: ";
	$moreinfo_label_chimney_in = "Διάμετρος Καπνοδόχου Τροφοδοσίας Αέρα: ";
	$moreinfo_label_chimney_out = "Διάμετρος Καπνοδόχου Απόρριψης Καυσαερίων: ";
	$moreinfo_files_tab = "Προβολή Αρχείων";
	$moreinfo_no_tank = "Δεν υπάρχει δεξαμενή με αυτό το ID.";
	$moreinfo_tank_download = "Λήψη";
	$moreinfo_tank_delete = "Διαγραφή";
	
	$tank_upload_title = "Προσθήκη Αρχείων";
	$tank_upload_base_success = " Η βάση δεδομένων ενημερώθηκε επιτυχώς! ";
	$tank_upload_base_error = " Σφάλμα! Η βάση δεδομένων δεν ενημερώθηκε. ";
	$tank_upload_other_error = " Σφάλμα! Παρουσιάστηκε κάποιο πρόβλημα. ";
	$tank_upload_info = "Ανεβάστε φωτογραφίες (JPG, JPEG, PNG, GIF) και αρχεία PDF για τη δεξαμενή ";
	
	$moreinfo_event_header = "Πληροφορίες Ραντεβού";
	$moreinfo_event_gen = "Στοιχεία Ραντεβού";
	$moreinfo_event_cust = "Στοιχεία Πελάτη & Διεύθυνση";
	$moreinfo_event_title = "Τίτλος: ";
	$moreinfo_event_start = "Έναρξη: ";
	$moreinfo_event_end = "Λήξη: ";
	$moreinfo_event_description = "Περιγραφή: ";
	$moreinfo_event_cust_name = "Ονοματεπώνυμο πελάτη: ";
	$moreinfo_event_cre_name = "Δημιουργός ραντεβού: ";
	
	$edit_event_header = "Επεξεργασία Ραντεβού";
	$edit_event_title = "Τίτλος * ";
	$edit_event_start = "Έναρξη *";
	$edit_event_end = "Λήξη *";
	$edit_event_description = "Περιγραφή ";
	$edit_event_creator_id = "Δημιουργός ραντεβού *";
	$edit_event_cust_id = "Ονοματεπώνυμο πελάτη *";
	$edit_event_reminder = "Προσθήκη υπενθύμισης";
	$edit_event_general = "Στοιχεία Ραντεβού";
	$edit_no_event = "Δεν υπάρχει ραντεβού με αυτό το ID.";
	
	$add_event_title = "Δημιουργία Ραντεβού";
	$add_event_header = "Δημιουργία Νέου Ραντεβού";
	$add_event_success = "Το ραντεβού αποθηκεύτηκε επιτυχώς. Περιμένετε...";
	$add_event_error = "Σφάλμα! Το ραντεβού δεν αποθηκεύτηκε. Περιμένετε...";
	
	$notifications_header = "Ειδοποιήσεις";
	$notifications_error = "Προσοχη! ";
	$notifications_error_msg1 = " Το πιστοποιητικό της δεξαμενής ";
	$notifications_error_msg2 = " του πελάτη ";
	$notifications_error_msg3 = " έχει λήξει.";
	$notifications_button = "Κανονίστε ένα ραντεβού";
	$notifications_warning = "Σημαντικο: ";
	$notifications_warning_msg1 = " λήγει σε ";
	$notifications_warning_msg2 = " ημέρες.";
	$notifications_no = "Δεν υπάρχουν ειδοποιήσεις.";
	$notifications_reminder = "Ειδοποιηση: ";
	$notifications_reminder_msg1 = "Το ραντεβού ";
	$notifications_reminder_msg2 = " έχει προγραμματιστεί για τις ";
	$notifications_reminder_msg3 = " και είχατε προσθέσει υπενθύμιση για τις ";
	$notifications_seen = "Το είδα!";
	$delete_notif_error = "Σφάλμα! Η διαγραφή δεν πραγματοποιήθηκε.";
	
	$calendar_header = "Ημερολόγιο Διαχείρησης Ραντεβού";
	$calendar_today = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Σημερινό πρόγραμμα";
	$calendar_next = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Επόμενα ραντεβού";
	$calendar_checklists = "Προγραμματισμένα ραντεβού για ";
	$calendar_print = "Εκτύπωση";
	$calendar_noevents = "Δεν υπάρχουν ραντεβού.";
	$calendar_checklists_day1 = "Δευτέρα";
	$calendar_checklists_day2 = "Τρίτη";
	$calendar_checklists_day3 = "Τετάρτη";
	$calendar_checklists_day4 = "Πέμπτη";
	$calendar_checklists_day5 = "Παρασκευή";
	$calendar_checklists_day6 = "Σάββατο";
	$calendar_checklists_day7 = "Κυριακή";
	$calendar_delete = "Θέλετε να διαγράψετε αυτό το ραντεβού;";
	$calendar_next_title = "Επόμενα ραντεβού";
	$calendar_checklists_title = "Σημερινά Ραντεβού";
	
	$events_next_header = "Προβολή Ραντεβού Επόμενων Ημερών";
	$events_next_all = "Όλα τα ραντεβού";
	$events_next_title = "Τίτλος";
	$events_next_start = "Έναρξη";
	$events_next_end = "Λήξη";
	$events_next_description = "Περιγραφή";
	$events_next_cust_name = "Πελάτης";
	$events_next_cre_name = "Δημιουργός";
	$events_next_no = "Δεν υπάρχουν προγραμματισμένα ραντεβού για τις επόμενες ημέρες.";
	
	$possession_qr_tech = "Τεχνικός: ";
	$possession_qr_phone = "Τηλέφωνο επικοινωνίας: ";
	$possession_qr_model = "Μοντέλο Δεξαμενής: ";
	
	$verify_success = "Ο λογαριασμός σας ενεργοποιήθηκε! Μπορείτε πλέον να συνδεθείτε πατώντας <a href='index.php'> εδώ</a>.";
	$verify_error = "Σφάλμα! Ο λογαριασμός σας δεν ενεργοποιήθηκε.";
	$verify_error1 = "Το url είναι άκυρο ή έχετε ήδη ενεργοποιήσει τον λογαριασμό σας. Προσπαθήστε να συνδεθείτε πατώντας <a href='index.php'> εδώ </a>.";
	$verify_error2 = "Μη επιτρεπτή ενέργεια. Παρακαλώ χρησιμοποιήστε τον σύνδεσμο επιβεβαίωσης που έχει σταλεί στο email σας.";
?>