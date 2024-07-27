Feature:
  In order to prove that all pages in website is correctly worked
  As a user
  I want to have a website pages scenario

  Scenario: Visit homepage
    Given I am on "/"
    And I follow redirect
    And I should be on "http://localhost/pl/"

  Scenario: Visit homepage with locale pl
    Given I am on "/pl/"
    #sliders data
    And I should see "Strony internetowe." in the "h5" from position 1
    And I should see "Aplikacjie webowe php, mysql, js." in the "h5" from position 2
    #article data
    And I should see "DevOps" in the "h1"
    And I should see "Aplikacje internetowe" in article title of 1
    And I should see "Testy" in article title of 2
    And I should see "Kontakt" in article title of 3
    #realization data
    And I should see "Przykładowe realizacje" in the "h2" from position 4
    And the response status code should be 200

  Scenario: Visit homepage with locale en
    Given I am on "/en/"
    #sliders data
    And I should see "Making a high quality website." in the "h5" from position 1
    And I should see "Creating web applications." in the "h5" from position 2
    #article data
    And I should see "DevOps" in the "h1"
    And I should see "Web application" in article title of 1
    And I should see "Tests" in article title of 2
    And I should see "Contact" in article title of 3
    #realization data
    And I should see "Example realization" in the "h2" from position 4
    And the response status code should be 200

  Scenario: Visit about me page with locale pl
    Given I am on "/pl/"
    And I follow to "O MNIE"
    And I should be on "http://localhost/pl/o-mnie"
    And I should see "O mnie" in the "h1"
    And the response status code should be 200

  Scenario: Visit about me page with locale en
    Given I am on "/en/"
    And I follow to "ABOUT ME"
    And I should be on "http://localhost/en/about-me"
    And I should see "No access for this page." in the "h1"
    And the response status code should be 200

  Scenario: Visit contact page with locale pl
    Given I am on "/pl/"
    And I follow to "KONTAKT"
    And I should be on "http://localhost/pl/kontakt"
    And I should see "Kontakt" in the "h1"
    And I send form "mail" with data clicking by "Wyślij"
      | email        | message     | number |
      | test@fake.pl | description | 4      |
    And the response should contain "Operacja matematyczna jest nieprawidłowa."
    And I send form "mail" with data clicking by "Wyślij"
      | email        | message     | number |
      | test@fake.pl | description | 5      |
    And the response should contain "Formularz został wysłany."
    And the response status code should be 200

  Scenario: Visit contact page with locale en
    Given I am on "/en/"
    And I follow to "CONTACT"
    And I should be on "http://localhost/en/contact"
    And I should see "Contact" in the "h1"
    And I send form "mail" with data clicking by "Send"
      | email        | message     | number |
      | test@fake.en | description | 4      |
    And the response should contain "Math operation is not valid."
    And I send form "mail" with data clicking by "Send"
      | email        | message     | number |
      | test@fake.en | description | 5      |
    And the response should contain "The form has been sent."
    And the response status code should be 200

  Scenario: Visit curriculum vitae page with locale pl
    Given I am on "/pl/"
    And I follow to "CURRICULUM VITAE"
    And I should be on "http://localhost/pl/curriculum-vitae"
    And the response status code should be 200

  Scenario: Visit curriculum vitae page with locale en
    Given I am on "/en/"
    And I follow to "CURRICULUM VITAE"
    And I should be on "http://localhost/en/curriculum-vitae"
    And the response status code should be 200

  Scenario: Visit curriculum vitae file locale pl
    Given I am on "/pl/"
    And I follow to "CV"
    And I should be on "http://localhost/upload/CV_PL.pdf"

  Scenario: Visit curriculum vitae file with locale en
    Given I am on "/en/"
    And I follow to "CV"
    And I should be on "http://localhost/upload/CV_EN.pdf"
