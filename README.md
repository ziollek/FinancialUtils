# FinancialUtils

FinancialUtils - some financial calculators i.e. APR (Annual Percentage Rate), IRR (Internal Rate of Return)

## Computation example

        $aprCalculator = new \Financial\Calculator\APR(new \Financial\Math\NewtonRaphsonMethod());

        $credit = new \Financial\Model\CreditDefinitionEqualInstallments(new \Financial\Util\Calendar());

        $credit->setDelay(0);
        $credit->setInstallmentValue(40.0);
        $credit->setInstallmentsFrequency(\Financial\Util\Calendar::FREQUENCY_MONTH);
        $credit->setInstallmentsCount(12);
        $credit->setBorrowedAmount(400.0);
        $credit->setOtherCosts(14.0);
        //expected output: apr = 51.52 %
        echo 'apr = ' . round($aprCalculator->calculate($credit), 2).' %'.PHP_EOL;

## Online demo (PL)

Try it:
http://webapi-solutions.pl:8080/rrso/

## Installation & testing

1. git clone https://github.com/ziollek/FinancialUtils.git && cd FinancialUtils
2. Install composer: php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
3. Install dependencies: ./composer.phar install
4. bin/phpunit


## Using via composer (sample for new project)

1. create composer.json

        {
            "require": {
                "publib/FinancialUtils": "dev-master"
            },
            "autoload": {
                "psr-0": {"": "src/"}
            },
            "repositories": [
                {
                    "type": "git",
                    "url": "https://github.com/ziollek/FinancialUtils.git"
                }
            ],
            "minimum-stability" : "dev"
        }

2. Install composer: php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"
3. Install dependencies: ./composer.phar install
4. Lib will be installed to vendor/publib/FinancialUtils/, your sources should be inside src/ and you should use PSR-0 naming class convention


