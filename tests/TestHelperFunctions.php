<?php

function createTestUSPhoneNumber()
{
    return substr(stripNonNumeric(app(Faker\Provider\en_US\PhoneNumber::class)->e164PhoneNumber()), 0, 10);
}