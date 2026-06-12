<?php
/**
 * Demo-only estimate calculator.
 *
 * @package MindGrid\RequestSystem
 */

declare(strict_types=1);

namespace MindGrid\RequestSystem\Requests;

if (! defined('ABSPATH')) {
    exit;
}

final class DemoEstimateCalculator
{
    /**
     * @param array<string, string> $data
     * @return array{total: float, low: int, high: int}
     */
    public static function calculate(array $data): array
    {
        $total = self::base_price($data['service_type'] ?? '');
        $total += self::number_value($data['boxes_bags_count'] ?? '') * 3;
        $total += '' !== ($data['heavy_items'] ?? '') ? 15 : 0;
        $total += self::floor_modifier($data);
        $total += self::number_value($data['demo_distance_km'] ?? '') * 2;
        $total += self::extra_services_modifier($data['extra_services'] ?? '');
        $total += self::urgency_modifier($data['request_urgency'] ?? '');

        return array(
            'total' => $total,
            'low' => self::round_to_nearest_five($total * 0.85),
            'high' => self::round_to_nearest_five($total * 1.15),
        );
    }

    public static function format_range(array $estimate): string
    {
        return (string) $estimate['low'] . ' - ' . (string) $estimate['high'] . ' лв';
    }

    private static function base_price(string $service_type): int
    {
        $prices = array(
            'moving_home' => 80,
            'moving_office' => 120,
            'moving_helpers' => 60,
            'transport_van' => 70,
            'clearing' => 90,
            'other' => 80,
        );

        return $prices[$service_type] ?? $prices['other'];
    }

    private static function floor_modifier(array $data): float
    {
        if ('no' !== ($data['has_elevator'] ?? '')) {
            return 0;
        }

        return self::number_value($data['floor'] ?? '') * 10;
    }

    private static function extra_services_modifier(string $value): int
    {
        if ('' === $value) {
            return 0;
        }

        $prices = array(
            'packing' => 15,
            'disassembly' => 20,
            'assembly' => 20,
            'disposal' => 20,
            'carry_up_stairs' => 10,
            'carry_down_stairs' => 10,
        );
        $total = 0;

        foreach (explode(',', $value) as $item) {
            $total += $prices[$item] ?? 0;
        }

        return $total;
    }

    private static function urgency_modifier(string $value): int
    {
        $prices = array(
            'urgent' => 30,
            'this_week' => 10,
            'flexible' => 0,
        );

        return $prices[$value] ?? 0;
    }

    private static function number_value(string $value): float
    {
        if ('' === $value || ! is_numeric($value)) {
            return 0;
        }

        return max(0, (float) $value);
    }

    private static function round_to_nearest_five(float $value): int
    {
        return (int) (round($value / 5) * 5);
    }
}
