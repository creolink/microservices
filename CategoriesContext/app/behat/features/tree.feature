Feature: Tree feture
 As a user I should get tree of all categories
 or retrieve a tree of children under a specific category.

  Scenario: As user I want to see full categories tree
    Given I am on "/api/tree"
    Then the response status code should be 200
    And the "content-type" response header is "application/json"
    And Json response contains categories

  Scenario: As user I want to retrieve a tree of visible
            children categories under a specific category
    Given I am on "/api/tree/categoryB1-slug"
    Then the response status code should be 200
    And the "content-type" response header is "application/json"
    And Json response contains categories:
      | id                                   |
      | d3c57bb5-21e6-11e8-9754-0242c0640a02 |
      | d3c57bb8-21e6-11e8-9754-0242c0640a02 |
      | d3c57bb9-21e6-11e8-9754-0242c0640a02 |
    And Json response does not contain categories:
      | id                                   |
      | d3c57bb1-21e6-11e8-9754-0242c0640a02 |
      | d3c57bb2-21e6-11e8-9754-0242c0640a02 |

