<?php

namespace App\Services\CurrencyRate;

use App\DTO\CurrencyRate\CurrencyPairRateDTO;
use Closure;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Psr\SimpleCache\InvalidArgumentException;

readonly class CurrencyRateCache
{
    private const ROOT_KEY = 'currency_rates_version';
    private const TTL = 600;

    public function __construct(
        private CacheRepository $cache
    ) {}

    /**
     * @param string $from
     * @param string $to
     * @param Closure $resolver
     * @return CurrencyPairRateDTO
     * @throws InvalidArgumentException
     */
    public function rememberPair(string $from, string $to, Closure $resolver): CurrencyPairRateDTO
    {
        $key = $this->pairKey($from, $to);

        return $this->cache->remember($key, self::TTL, $resolver);
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->cache->increment(self::ROOT_KEY);
    }

    /**
     * @param string $from
     * @param string $to
     * @return string
     * @throws InvalidArgumentException
     */
    private function pairKey(string $from, string $to): string
    {
        $version = $this->cache->get(self::ROOT_KEY, 1);

        return sprintf(
            'currency_rates:%d:%s:%s',
            $version,
            strtoupper($from),
            strtoupper($to)
        );
    }
}
