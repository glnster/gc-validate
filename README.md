gc-validate
===========

validation in js for a specific form

Flow:
- click on the Next button
- has the page been checked for blanks?
    - yes: goto next page
    - no: check it for blanks. trigger a validation switch
        - show all the fields that are blank and set focus to the first blank field
