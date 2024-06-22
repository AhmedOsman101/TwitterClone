export function isEqualObjects (obj1, obj2) {
  // If both are strictly equal, return true
  if (obj1 === obj2) return true;

  // If either is not an object or is null, return false
  if (
    typeof obj1 !== "object" ||
    obj1 === null ||
    typeof obj2 !== "object" ||
    obj2 === null
  ) {
    return false;
  }

  // Get keys of both objects
  const keys1 = Object.keys(obj1);
  // const keys2 = Object.keys(obj2);

  // If number of keys is different, objects are not equal
  // if (keys1.length !== keys2.length) return false;

  // Check if all keys and their values are equal
  return keys1.every((key) => {
    // If the key does not exist in obj2, return false
    if (!obj2.hasOwnProperty(key)) return false;

    const val1 = obj1[key];
    const val2 = obj2[key];

    // Check if both values are objects and recursively compare
    const areBothObjects =
      typeof val1 === "object" &&
      val1 !== null &&
      typeof val2 === "object" &&
      val2 !== null;

    return areBothObjects ? isEqualObjects(val1, val2) : val1 === val2;
  });
}

export function formatNumber (num) {
  if (num >= 1000000000) {
    return (num / 1000000000).toFixed(num % 1000000000 === 0 ? 0 : 1) + 'B';
  } else
    if (num >= 1000000) {
      return (num / 1000000).toFixed(num % 1000000 === 0 ? 0 : 1) + 'M';
    } else
      if (num >= 1000) {
        return (num / 1000).toFixed(num % 1000 === 0 ? 0 : 1) + 'K';
      } else {
        return num.toString();
      }
}
