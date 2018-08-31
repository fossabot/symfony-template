# Release checklist
What still needs to be done to deploy & publish the application. Mark points which are already completed.

- [ ] set sensible defaults in `.env.dist`, and put these in `phpunit.xml.dist` too
- [ ] adapt the repository name & description in `composer.json`
- [ ] adapt the repository link in `deploy.php`
- [ ] adapt the deploy path in `servers_template.yml`
- [ ] start the CI services which are configured in the `README.md`
- [ ] generate favicons with [realfavicongenerator.net](https://realfavicongenerator.net/)