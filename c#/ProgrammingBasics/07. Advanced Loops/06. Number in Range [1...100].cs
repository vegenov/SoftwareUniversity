﻿using System;

namespace _06.Number_in_Range__1._._._100_
{
    class Program
    {
        static void Main()
        {
            Console.WriteLine("Еnter a number in the range [1...100]: ");
            int n = int.Parse(Console.ReadLine());

            while (n < 1 || n > 100)
            {
                Console.WriteLine("Invalid number!");
                n = int.Parse(Console.ReadLine());
            }
            Console.WriteLine($"The number is: {n}");
        }
    }
}