<?php

namespace Tests\Unit\Services;

use App\DTO\CurrencyConvert\CurrencyConvertRequestDTO;
use App\DTO\CurrencyConvert\CurrencyConvertResponseDTO;
use App\DTO\CurrencyRate\CurrencyPairRateDTO;
use App\Exceptions\CurrencyRateNotFoundException;
use App\Services\CurrencyConverterService;
use App\Services\CurrencyRateService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CurrencyConverterServiceTest extends TestCase
{
    private CurrencyConverterService $converter;
    private MockObject|CurrencyRateService $currencyRateServiceMock;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->currencyRateServiceMock = $this->createMock(CurrencyRateService::class);
        $this->converter = new CurrencyConverterService($this->currencyRateServiceMock);
    }

    public function testConvertSuccessfully(): void
    {
        $requestDto = new CurrencyConvertRequestDTO(
            amount: 100,
            from: 'USD',
            to: 'EUR'
        );

        $this->currencyRateServiceMock->expects($this->once())
            ->method('getCurrencyPairRateByCodes')
            ->with('USD', 'EUR')
            ->willReturn(new CurrencyPairRateDTO(
                fromCode: $requestDto->from,
                toCode: $requestDto->to,
                fromRate: 1.0,
                toRate: 0.85
            ));

        $response = $this->converter->convert($requestDto);

        $this->assertInstanceOf(CurrencyConvertResponseDTO::class, $response);
        $this->assertEquals(100, $response->amount);
        $this->assertEquals('USD', $response->from);
        $this->assertEquals('EUR', $response->to);
        $this->assertEquals(85.0, $response->result);
    }

    public function testConvertWithDifferentPrecision(): void
    {
        $requestDto = new CurrencyConvertRequestDTO(
            amount: 100,
            from: 'USD',
            to: 'EUR'
        );

        $this->currencyRateServiceMock->method('getCurrencyPairRateByCodes')
            ->willReturn(new CurrencyPairRateDTO(
                fromCode: $requestDto->from,
                toCode: $requestDto->to,
                fromRate: 1.0,
                toRate: 0.854321
            ));

        $response = $this->converter->convert($requestDto, 6);

        $this->assertEquals(85.432100, $response->result);
    }

    public function testConvertThrowsExceptionWhenRateNotFound(): void
    {
        $requestDto = new CurrencyConvertRequestDTO(
            amount: 100,
            from: 'USD',
            to: 'EUR'
        );

        $this->currencyRateServiceMock->method('getCurrencyPairRateByCodes')
            ->willThrowException(new CurrencyRateNotFoundException('Rate not found'));

        $this->expectException(CurrencyRateNotFoundException::class);

        $this->converter->convert($requestDto);
    }
}
