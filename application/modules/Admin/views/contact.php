<?php include('common/header.php');?>
<section>
    <div class="Contact_section">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="contact_section1">
              <h1>Contacts</h1>
              <?php 
                $html_content = '';
                foreach ($get_contacts as $key => $contact_value) {
                  $html_content.= '<div class="send_file_section">';
                  $html_content.= '<h2>'.$contact_value['Name'].'</h2>';
                  $html_content.= '<ul>';
                  foreach ($contact_value['get_people'] as $key => $value) {
                    $html_content.= '<li>'.$value['Function'].'';
                    $html_content.= '<span>'.$value['Name'].' '.$value['Surname'].' '.$value['Mobile_phone'].' / '.$value['email'].'';
                    $html_content.= '</span>';
                    $html_content.= '</li>';
                  }
                  $html_content.= '</ul>';
                  $html_content.= '</div>';
                }
                echo $html_content;
              ?>
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php include('common/footer.php');?>
