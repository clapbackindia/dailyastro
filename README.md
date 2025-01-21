# Daily Astro Module for UNA CMS

## Overview
This module displays a daily horoscope based on the user's birth date.  It fetches horoscope data from the [Horoscope App API](https://horoscope-app-api.vercel.app/api/v1/get-horoscope/daily) and caches the result for 24 hours.

## Features
- Displays daily horoscopes personalized to the user's zodiac sign.
- Caches horoscope data to reduce API calls and improve performance.
- Handles errors gracefully and displays user-friendly messages.
- Integrates with UNA CMS page builder using service methods.

## Installation
1. Download the module
2. Upload to your UNA CMS application in './modules/clapback/' directory. If directory 'clapback' does not exist, create one.
3. Install via UNA Studio

## Requirements
- UNA CMS Version: 14.0.0 RC2
- PHP Version: 8.0
- Additional Dependencies: None

## Configuration
- The module requires the user to have their birth date set in their profile.  The module retrieves the birth date and determines the appropriate zodiac sign.

## Usage
The module provides two main service methods:

- `serviceAstro()`: This method can be called directly from a UNA CMS page to display the daily horoscope.
- `serviceGetBlock()`: This method returns the horoscope as an array, which can be used to integrate the horoscope into other parts of the UNA CMS.


## Contributing
1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License
MIT - Jerry Jones

## Contact
- Module Author: Jerry Jones
- Project Link: (https://github.com/clapback/dailyastro)