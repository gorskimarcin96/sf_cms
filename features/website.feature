Feature:
  In order to prove that all pages in website is correctly worked
  As a user
  I want to have a website pages scenario

#  Background:
#    Given the database is clean
#    And there are users
#      | id | email           | roles      | password |
#      | 1  | admin@email.com | ROLE_ADMIN | password |
#    And there are sliders
#      | id | user_id | file_fn    |
#      | 1  | 1       | slide.jpg  |
#      | 2  | 1       | slide2.jpg |
#    And there are slider translations
#      | id | locale | title       |
#      | 1  | en     | slider en 1 |
#      | 1  | pl     | slider pl 1 |
#      | 2  | en     | slider en 2 |
#      | 2  | pl     | slider pl 2 |
#    And there are articles
#      | id | user_id | file_fn    |
#      | 1  | 1       | fake_1.jpg |
#      | 2  | 1       | fake_2.jpg |
#      | 3  | 1       | fake_3.jpg |
#    And there are article translations
#      | id | locale | title        | description              |
#      | 1  | en     | article en 1 | article description en 1 |
#      | 1  | pl     | article pl 1 | article description pl 1 |
#      | 2  | en     | article en 2 | article description en 2 |
#      | 2  | pl     | article pl 2 | article description pl 2 |
#      | 3  | en     | article en 3 | article description en 3 |
#      | 3  | pl     | article pl 3 | article description pl 3 |
#    And there are realizations
#      | id | user_id | file_fn    | title     | url |
#      | 1  | 1       | fake_1.png | example 1 | #   |
#      | 2  | 1       | fake_2.png | example 2 | #   |
#    And there are realization translations
#      | id | locale | description                  |
#      | 1  | en     | realization description en 1 |
#      | 1  | pl     | realization description pl 1 |
#      | 2  | en     | realization description en 2 |
#      | 2  | pl     | realization description pl 2 |

  Scenario: Visit homepage
    Given I am on homepage
    And I should be redirect to "/pl"

  Scenario: Visit homepage with locale pl
    Given I am on "/pl/"
    And I should see "DevOps" in the "h1"
    And I should see "Aplikacje internetowe" in article title of 1
    And I should see "Testy" in article title of 2

    

    And I should see "Kontakt" in article title of 3
    And I should see "Strony internetowe." in the "h5" from position 1
    And I should see "Aplikacjie webowe php, mysql, js." in the "h5" from position 2
#    And the response should contain "slider pl 1"
#    And the response should contain "slider pl 2"
#    And the response should contain "article pl 1"
#    And the response should contain "article description pl 1"
#    And the response should contain "article pl 2"
#    And the response should contain "article description pl 2"
#    And the response should contain "article pl 3"
#    And the response should contain "article description pl 3"
#    And the response should contain "example 1"
#    And the response should contain "realization description pl 1"
#    And the response should contain "example 2"
#    And the response should contain "realization description pl 2"
#
#  Scenario: Visit homepage with locale en
#    Given I am on "/en"
#    And I should see "article en 1" in the "h1" element
#    And the response should contain "slider en 1"
#    And the response should contain "slider en 2"
#    And the response should contain "article en 1"
#    And the response should contain "article description en 1"
#    And the response should contain "article en 2"
#    And the response should contain "article description en 2"
#    And the response should contain "article en 3"
#    And the response should contain "article description en 3"
#    And the response should contain "example 1"
#    And the response should contain "realization description en 1"
#    And the response should contain "example 2"
#    And the response should contain "realization description en 2"
#    And the response status code should be 200
#
#  Scenario: Visit about me page with locale pl
#    Given I am on "/pl"
#    And I follow "O MNIE"
#    And I should be on "/pl/o-mnie"
#    And I should see "O mnie" in the "h1" element
#    And the response status code should be 200
#
#  Scenario: Visit about me page with locale en
#    Given I am on "/en"
#    And I follow "ABOUT ME"
#    And I should be on "/en/about-me"
#    And I should see "No access for this page." in the "h1" element
#    And the response status code should be 200
#
#  Scenario: Visit contact page with locale pl
#    Given I am on "/pl"
#    And I follow "KONTAKT"
#    And I should be on "/pl/kontakt"
#    And I should see "Kontakt" in the "h1" element
#    And I fill in "mail_email" with "test@fake.pl"
#    And I fill in "mail_message" with "description"
#    And I fill in "mail_number" with "4"
#    And I press "Wyślij"
#    And the response should contain "Operacja matematyczna jest nieprawidłowa."
#    And I fill in "mail_email" with "test@fake.pl"
#    And I fill in "mail_message" with "description"
#    And I fill in "mail_number" with "5"
#    And I press "Wyślij"
#    And the response should contain "Formularz został wysłany."
#    And the response status code should be 200
#
#  Scenario: Visit contact page with locale en
#    Given I am on "/en"
#    And I follow "CONTACT"
#    And I should be on "/en/contact"
#    And I should see "Contact" in the "h1" element
#    And I fill in "mail_email" with "test@fake.en"
#    And I fill in "mail_message" with "description"
#    And I fill in "mail_number" with "4"
#    And I press "Send"
#    And the response should contain "Math operation is not valid."
#    And I fill in "mail_email" with "test@fake.en"
#    And I fill in "mail_message" with "description"
#    And I fill in "mail_number" with "5"
#    And I press "Send"
#    And the response should contain "The form has been sent."
#    And the response status code should be 200
#
#  Scenario: Visit curriculum vitae page with locale pl
#    Given I am on "/pl"
#    And I follow "CURRICULUM VITAE"
#    And I should be on "/pl/curriculum-vitae"
#    And the response status code should be 200
#
#  Scenario: Visit curriculum vitae page with locale en
#    Given I am on "/en"
#    And I follow "CURRICULUM VITAE"
#    And I should be on "/en/curriculum-vitae"
#    And the response status code should be 200
#
#  Scenario: Visit curriculum vitae file locale pl
#    Given I am on "/pl"
#    And I follow blank link "CV"
#    And I should be on "/upload/CV_PL.pdf"
#
#  Scenario: Visit curriculum vitae file with locale en
#    Given I am on "/en"
#    And I follow blank link "CV"
#    And I should be on "/upload/CV_EN.pdf"
