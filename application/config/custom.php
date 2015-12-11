<?php


$config['progression'] = array(
  [ 1, 'contact_data', 'steps/contact_data', 'Contact_data_model', 'Kontakt'],
  [ 2, 'education', 'steps/education', 'Education_model', 'Ausbildung'],
  [ 3, 'internships', 'steps/internships', 'Internships_model', 'Praktika'],
  [ 4, 'it_skills', 'steps/it_skills', 'It_skills_model', 'IT-Kenntnisse'],
  [ 5, 'uploads', 'steps/uploads', 'Uploads_model', 'Unterlagen'],
  [ 6, 'other', 'steps/other', 'Other_model', 'Sonstiges'],
  [ 7, 'summary', 'steps/summary', 'Summary_model', 'Zusammenfassung']
);


$config['db_value_translations'] = array();
$config['db_value_translations']['schulabschluesse'] = array(
  'qualizifierender_hauptschulabschluss' => 'Qualizifierender Hauptschulabschluss',
  'mittlerer_bildungsabschluss' => 'mittlerer Bildungsabschluss',
  'fachabitur' => 'Fachabitur',
  'abitur' => 'Abitur',
  'keiner' => 'keiner'
);
