<?php
/**
 * Redondeo de montos de venta al múltiplo de 0.10 (décimas).
 *
 * ¿Qué es lo correcto?
 * -------------------
 * - SUNAT/Perú no exige un método concreto; lo importante es ser consistente.
 * - Redondear HACIA ABAJO: favorece al cliente (cobras menos). Ej: 160.86 → 160.80
 * - Redondear HACIA ARRIBA: favorece al local (cobras más). Ej: 160.86 → 160.90
 * - Redondear AL MÁS PRÓXIMO: criterio neutro y muy usado en contabilidad.
 *   Ej: 160.86 → 160.90, 160.84 → 160.80
 *
 * Puedes cambiar REDONDEO_VENTA_MODO abajo según tu política.
 */
define('REDONDEO_VENTA_MODO', 'up'); // 'down' = abajo | 'up' = arriba (favorece al local) | 'nearest' = al más próximo

/**
 * Redondea un monto al múltiplo de 0.10 según el modo configurado.
 *
 * @param float|string $valor Monto a redondear
 * @return float Monto redondeado a 1 decimal (ej. 160.80)
 */
function redondear_venta_10centimos($valor) {
    $v = (float) $valor;
    $x10 = round($v * 10, 8);
    switch (REDONDEO_VENTA_MODO) {
        case 'up':
            return (float)(ceil($x10) / 10);
        case 'nearest':
            return (float)(round($x10) / 10);
        case 'down':
        default:
            return (float)(floor($x10) / 10);
    }
}

/**
 * Alias para no romper código existente. Usa el mismo modo que redondear_venta_10centimos().
 */
function redondear_abajo_10centimos($valor) {
    return redondear_venta_10centimos($valor);
}
