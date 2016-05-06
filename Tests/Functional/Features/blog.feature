Feature: Load and display a Markdown blog
  As a backend PHP developer,
  I should be able to easily setup a blog
  on a Symfony2 website

  Scenario: Use a blog library built on Markdown files with a Yaml register
    Given I have built my Markdown Blog Library from the fixtures
    Then the index should contain "8" blog posts
    And the index have the following entries:
      | A-dev-tale            |
      | A-long-one            |
      | Constructive-thoughts |
      | Dev-tale-sequel       |
      | My-first-post         |
      | XYZ-chapter-one       |
      | XYZ-chapter-three     |
      | XYZ-chapter-two       |
    And the post "My-first-post" should have the following properties:
      | category    | Blog       |
      | publishDate | 2016-04-01 |
    And the post "Constructive-thoughts" should have the following properties:
      | category    | Blog       |
      | publishDate | 2016-04-01 |
    And the post "A-dev-tale" should have the following properties:
      | category    | Dev                 |
      | publishDate | 2016-05-01          |
      | tags        | github; open-source |
    And the post "A-long-one" should have the following properties:
      | publishDate | 2016-05-15 |
    And if I search for posts published on the "2016-04-01" I should be given:
      | Constructive-thoughts |
      | My-first-post         |
    And if I search for posts published on the "2016-05-20" I should be given:
      | XYZ-chapter-one   |
      | XYZ-chapter-three |
      | XYZ-chapter-two   |
    And if I search for posts published in the category "Dev" I should be given:
      | A-dev-tale      |
      | Dev-tale-sequel |
    And if I search for posts published tagged as "xyz" I should be given:
      | XYZ-chapter-one   |
      | XYZ-chapter-three |
      | XYZ-chapter-two   |
