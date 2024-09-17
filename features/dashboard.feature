Feature:
  In order to prove that all pages in admin panel is correctly worked
  As a user
  I want to have a admin panel pages scenario

  Background:
    Given the counter is clean
    And update email "admin@fake.com" and password "password" for main user

  Scenario: Visit all pages for pl
    Given I am on "/pl/admin"
    And the counter should not be existed for "/pl/admin"
    And I follow redirect
    And I should be on "http://localhost/pl/login"
    And the counter should be existed for "/pl/login"
    And the entry counter should be increased to 1 for "/pl/login"
    And the refresh counter should be increased to 1 for "/pl/login"
    And the response status code should be 200
    And I send login form with data clicking by "Zaloguj się"
      | _username      | _password |
      | admin@fake.com | password  |
    And I follow redirect
    And I should be on "http://localhost/pl/admin"
    And I should see "Dashboard" in the "h1"
    And the response status code should be 200
    And I follow to "Slider"
    And I should see "Slider" in the "h1"
    And I should see 2 rows
    And the response status code should be 200
    And I follow to "Article"
    And I should see "Article" in the "h1"
    And I should see 3 rows
    And the response status code should be 200
    And I follow to "Realization"
    And I should see "Realization" in the "h1"
    And I should see 3 rows
    And the response status code should be 200
    And I follow to "CV PL"
    And I should see "CV maker" in the "h1.d-inline"
    And I follow to "Wróć"
    And I should be on "http://localhost/pl/admin"
    And I follow to "Logout"
    And I follow redirect
    And I should be on "http://localhost/"
    And I follow redirect
    And I should be on "http://localhost/pl/"
    And the counter should be existed for "/pl/"
    And the entry counter should be increased to 1 for "/pl/"
    And the refresh counter should be increased to 1 for "/pl/"
    And the response status code should be 200

  Scenario: Visit all pages for en
    Given I am on "/en/admin"
    And the counter should not be existed for "/en/admin"
    And I follow redirect
    And I should be on "http://localhost/en/login"
    And the counter should be existed for "/en/login"
    And the entry counter should be increased to 1 for "/en/login"
    And the refresh counter should be increased to 1 for "/en/login"
    And the response status code should be 200
    And I send login form with data clicking by "Sign in"
      | _username      | _password |
      | admin@fake.com | password  |
    And I follow redirect
    And I should be on "http://localhost/en/admin"
    And I should see "Dashboard" in the "h1"
    And the response status code should be 200
    And I follow to "Slider"
    And I should see "Slider" in the "h1"
    And I should see 2 rows
    And the response status code should be 200
    And I follow to "Article"
    And I should see "Article" in the "h1"
    And I should see 3 rows
    And the response status code should be 200
    And I follow to "Realization"
    And I should see "Realization" in the "h1"
    And I should see 3 rows
    And the response status code should be 200
    And I follow to "CV EN"
    And I should see "CV maker" in the "h1.d-inline"
    And I follow to "Wróć"
    And I should be on "http://localhost/en/admin"
    And I follow to "Logout"
    And I follow redirect
    And I should be on "http://localhost/"
    And I follow redirect
    And I should be on "http://localhost/pl/"
    And the counter should be existed for "/pl/"
    And the entry counter should be increased to 1 for "/pl/"
    And the refresh counter should be increased to 1 for "/pl/"
    And the response status code should be 200
