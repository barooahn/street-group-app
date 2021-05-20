# Tests to be implemented

- High level test 
    Check that given a CSV of people the out put is as expected
    e.g. 

    Given: 
    
    `“Mr John Smith”, "Mrs A Jones", "Dr P Smith & Mrs Smith"`

    Results:  
    
    $person[‘title’] => ‘Mr’,
    $person[‘first_name’] => “John”,
    $person[‘initial’] => null,
    $person[‘last_name’] => “Smith”

    $person[‘title’] => ‘Mrs’,
    $person[‘first_name’] => null,
    $person[‘initial’] => A,
    $person[‘last_name’] => “Jones”

    $person[‘title’] => ‘Dr’,
    $person[‘first_name’] => null,
    $person[‘initial’] => P,
    $person[‘last_name’] => “Smith”

    $person[‘title’] => ‘Mrs’,
    $person[‘first_name’] => null,
    $person[‘initial’] => null,
    $person[‘last_name’] => “Smith”

Method tests: 

    normalise
        Given a string expect a string returned with all special characters removed with the exception of "-", "&" " " ","

            e.g. "Mr! J Panther", 

            returns: Mr J Panther


    isHeader 
        Given a CSV with the first item not in $titles array expect true
        Given a CSV with the first item in $titles array expect false

        eg 

        People,
        Mr John Smith,
        Mrs A Jones,
        Dr P Smith & Mrs Smith 

        returns true

        Mr John Smith,
        Mrs A Jones,
        Dr P Smith & Mrs Smith

        returns false

    is Title 
        Given a string in the $titles array expect true
        Given a string not in $titles array expect false 

        eg

        Mister return true

        John returns false

    isOnePerson
        Given a string containing '&' or 'and' expect true
        Given a string not containing '&' or 'and' expect false 

        eg

        `“Mr and Mrs Smith”` returns true

        Mr Smith returns false


    formatPerson
        Given a string containing 'Mr John Smith' expect:     
        
            $person[‘title’] => ‘Mr’,
            $person[‘first_name’] => “John”,
            $person[‘initial’] => null,
            $person[‘last_name’] => “Smith”

        Given a string containing 'Mr' expect:  No $person created

        Given a string containing > 4 words expect:  No $person created

    splitPeople
        
        Given a string containing '&' or 'and' expect 

        two people to be created (calling formatPeople)

        eg

            'Mr and Mrs Smith'

            $person[‘title’] => ‘Mr’,
            $person[‘first_name’] => null,
            $person[‘initial’] => null,
            $person[‘last_name’] => “Smith”

            $person[‘title’] => ‘Mrs’,
            $person[‘first_name’] => null,
            $person[‘initial’] => null,
            $person[‘last_name’] => “Smith”

    isInitial

        Given a string if it is one character return true
        Given a string if it is more or less than one character return false

        eg

        'I'  return true

        'IP' return false
         


# Homeowner Names - Technical Test

> Please do not spend too long on this test, 2 hours should be more than sufficient. You may
choose to create a full application with a basic front-end to upload the CSV, or a simple class
that loads the CSV from the filesystem.

You have been provided with a CSV from an estate agent containing an export of their
homeowner data. If there are multiple homeowners, the estate agent has been entering both
people into one field, often in different formats.

Our system stores person data as individual person records with the following schema:

### Person

- title - required
- first_name - optional
- initial - optional
- last_name - required

Write a program that can accept the CSV and output an array of people, splitting the name into
the correct fields, and splitting multiple people from one string where appropriate.

For example, the string “Mr & Mrs Smith” would be split into 2 people.

## Example Outputs

Input
`“Mr John Smith”`

Output
```
$person[‘title’] => ‘Mr’,
$person[‘first_name’] => “John”,
$person[‘initial’] => null,
$person[‘last_name’] => “Smith”
```

Input
`“Mr and Mrs Smith”`

Output
```
$person[‘title’] => ‘Mr’,
$person[‘first_name’] => null,
$person[‘initial’] => null,
$person[‘last_name’] => “Smith”
$person[‘title’] => ‘Mrs’,
$person[‘first_name’] => null,
$person[‘initial’] => null,
$person[‘last_name’] => “Smith”
```

Input
`“Mr J. Smith”`

Output
```
$person[‘title’] => ‘Mr’,
$person[‘first_name’] => null,
$person[‘initial’] => “J”,
$person[‘last_name’] => “Smith”
```


Test Data

homeowner
Mr John Smith
Mrs Jane Smith
Mister John Doe
Mr Bob Lawblaw
Mr and Mrs Smith
Mr Craig Charles
Mr M Mackie
Mrs Jane McMaster
Mr Tom Staff and Mr John Doe
Dr P Gunn
Dr & Mrs Joe Bloggs
Ms Claire Robbo
Prof Alex Brogan
Mrs Faye Hughes-Eastwood
Mr F. Fredrickson
