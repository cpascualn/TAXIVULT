export default function formatCoords(value) {
    // Convertir el valor a número flotante
    const number = parseFloat(value);
  
    // Verificar si es un número válido
    if (isNaN(number)) return "0.000000000"; // Si no es un número válido, devolvemos un valor seguro
  
    // Dividir el número en parte entera y parte decimal
    const [integerPart, decimalPart = ""] = number.toString().split(".");
  
    // Parte entera no puede ser mayor a (12 - 9 decimales) = 3 dígitos
    const maxIntegerLength = 3;
    const truncatedInteger = integerPart.slice(0, maxIntegerLength);
  
    // Parte decimal puede ser de hasta 9 dígitos
    const truncatedDecimal = decimalPart.slice(0, 9);
  
    // Combinar parte entera y decimal con el punto
    const result = `${truncatedInteger}.${truncatedDecimal}`;
  
    // Asegurar que siempre haya 9 decimales, incluso si el número tiene menos
    const finalResult = result.length > 12 ? result.slice(0, 12) : result;
  
    // Validar que el número tiene como máximo 12 caracteres totales
    return finalResult.slice(0, 12);
  }