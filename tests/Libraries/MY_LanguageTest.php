<?php

namespace Tests\Libraries;

use App\Libraries\MY_Language;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class MY_LanguageTest extends CIUnitTestCase
{
    public function testGetLine_ReturnsLocalizedTranslationWhenPresent(): void
    {
        $language = new MY_Language('tl');

        $this->assertSame(
            'Hindi sapat ang mga bayad para sa kabuuang dapat bayaran.',
            $language->getLine('Sales.amount_due_not_covered'),
        );
    }

    public function testGetLine_FallsBackToEnglishWhenTranslationIsEmptyString(): void
    {
        $language = new MY_Language('tl');

        $this->assertSame('Rewards', $language->getLine('Sales.rewards_package'));
    }

    public function testGetLine_FallsBackToEnglishWhenLaoTranslationIsEmptyString(): void
    {
        $language = new MY_Language('lo');

        $this->assertSame('Rewards', $language->getLine('Sales.rewards_package'));
    }

    public function testGetLine_FallsBackToEnglishWhenBulgarianLoginTranslationIsEmptyString(): void
    {
        $language = new MY_Language('bg');

        $this->assertSame('Please verify that you are not a robot.', $language->getLine('Login.invalid_gcaptcha'));
        $this->assertSame('Invalid username and/or password.', $language->getLine('Login.invalid_username_and_password'));
    }

    public function testGetLine_FallsBackToEnglishWhenBulgarianReceivingsAndReportsTranslationsAreEmpty(): void
    {
        $language = new MY_Language('bg');

        $this->assertSame('Email', $language->getLine('Receivings.supplier_email'));
        $this->assertSame('Discount', $language->getLine('Receivings.discount'));
        $this->assertSame('CNL', $language->getLine('Reports.code_canceled'));
    }

    public function testGetLine_FallsBackToEnglishForFinishQuoteWithoutPayment(): void
    {
        $language = new MY_Language('da');

        $this->assertSame(
            'Finish Quote/Invoice without payment',
            $language->getLine('Sales.key_finish_quote'),
        );
    }

    public function testGetLine_FallsBackToEnglishForAttributeSuccessfulAddingWhenEmpty(): void
    {
        $language = new MY_Language('fr');

        $this->assertSame(
            'You have successfully added the attribute',
            $language->getLine('Attributes.definition_successful_adding'),
        );
    }

    public function testGetLine_FallsBackToEnglishForExpensesTaxAmountNumberWhenEmpty(): void
    {
        $language = new MY_Language('de-DE');

        $this->assertSame(
            'Tax Amount must be a number',
            $language->getLine('Expenses.tax_amount_number'),
        );
    }

    public function testGetLine_FallsBackToEnglishForItemKitsDuplicateNumberWhenEmpty(): void
    {
        $language = new MY_Language('fr');

        $this->assertSame(
            'Item Kit Number is already present in the database.',
            $language->getLine('Item_kits.item_number_duplicate'),
        );
    }

    public function testGetLine_FallsBackToEnglishForEnGbWhenTranslationIsEmptyString(): void
    {
        $language = new MY_Language('en-GB');

        $this->assertSame('Cheque', $language->getLine('Sales.check'));
        $this->assertSame(
            'Item Kit Number is already present in the database.',
            $language->getLine('Item_kits.item_number_duplicate'),
        );
        $this->assertSame(
            'Tax Amount must be a number',
            $language->getLine('Expenses.tax_amount_number'),
        );
        $this->assertSame(
            'You have successfully added the attribute',
            $language->getLine('Attributes.definition_successful_adding'),
        );
    }

    public function testGetLine_FallsBackToEnglishForNoAttributesToDisplayWhenEmpty(): void
    {
        $idLanguage = new MY_Language('id');
        $this->assertSame('No Attributes to display', $idLanguage->getLine('Attributes.no_attributes_to_display'));

        $nbLanguage = new MY_Language('nb');
        $this->assertSame('No Attributes to display', $nbLanguage->getLine('Attributes.no_attributes_to_display'));
    }

    public function testGetLine_FallsBackToEnglishForDefinitionSuccessfulDeletedWhenEmpty(): void
    {
        $language = new MY_Language('da');

        $this->assertSame(
            'You have successfully deleted',
            $language->getLine('Attributes.definition_successful_deleted'),
        );
    }

    public function testGetLine_FallsBackToEnglishForConfigStatisticsWhenEmpty(): void
    {
        $language = new MY_Language('de-CH');
        $this->assertSame('Send Statistics', $language->getLine('Config.statistics'));

        $hrLanguage = new MY_Language('hr');
        $this->assertSame('Send Statistics', $hrLanguage->getLine('Config.statistics'));
    }

    public function testGetLine_FallsBackToEnglishForCustomersAvailablePointsWhenEmpty(): void
    {
        $language = new MY_Language('da');

        $this->assertSame('Points Available', $language->getLine('Customers.available_points'));
    }
}
