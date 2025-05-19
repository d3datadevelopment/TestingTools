[![deutsche Version](https://logos.oxidmodule.com/de2_xs.svg)](README.md)
[![english version](https://logos.oxidmodule.com/en2_xs.svg)](README.en.md)

# Tools for better testable code

This package provides tools to circumvent difficulties when testing plug-in code from customisable frameworks (e.g. shop software).

- method bundles can be included as traits depending on the class.

- `Production\IsMockable`: contains methods for mocking parent calls
- `Development\CanAccessRestricted`: contains methods for better accessibility of protected code

## Table of content

- [Installation](#installation)
- [How to use](#how-to-use)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [License](#license)

## Installation

This package requires a project installed with Composer.

Open a command line and navigate to the root directory of the installation. Execute the following command. Adapt the path details to your installation environment.

```bash
php composer require d3/testingtools:^1.0
``` 

## How to use

Include the respective trait in your class and use the desired method in your code:

```
use \D3\TestingTools\Production\IsMockable;
```
```
use \D3\TestingTools\Development\CanAccessRestricted;
```

## Changelog

See [CHANGELOG](CHANGELOG.md) for further informations.

## Contributing

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue. Don't forget to give the project a star! Thanks again!

- Fork the Project
- Create your Feature Branch (git checkout -b feature/AmazingFeature)
- Commit your Changes (git commit -m 'Add some AmazingFeature')
- Push to the Branch (git push origin feature/AmazingFeature)
- Open a Pull Request

## License
(status: 2022-11-11)

Distributed under the MIT license.

```
Copyright (c) D3 Data Development (Inh. Thomas Dartsch)
```

For full copyright and licensing information, please see the [LICENSE](LICENSE.md) file distributed with this source code.