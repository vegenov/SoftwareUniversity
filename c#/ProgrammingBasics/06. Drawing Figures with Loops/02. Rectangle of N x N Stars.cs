﻿using System;

namespace _02.Rectangle_of_N_x_N_Stars
{
    class Program
    {
        static void Main()
        {
            var n = int.Parse(Console.ReadLine());

            for (int rows = 1; rows <= n; rows++)
            {
                for (int col = 1; col <= n; col++)
                    Console.Write("*");

                Console.WriteLine();
            }

        }
    }
}