﻿using System;

class Program
{
    public static void Main()
    {
        var n = int.Parse(Console.ReadLine());
        n = Math.Abs(n);
        int sum = 0;
        while (n != 0)
        {
            var digit = n % 10;
            sum += digit;
            n /= 10;
        }
        Console.WriteLine(sum);
    }
}