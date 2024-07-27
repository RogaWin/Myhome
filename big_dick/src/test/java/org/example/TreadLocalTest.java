package org.example;

import org.junit.jupiter.api.Test;

public class TreadLocalTest {
    @Test
    public void testThreadLocal() {
        //开启两个线程
        ThreadLocal t1 = new ThreadLocal();

        new Thread(()->{
            t1.set("小严");
            System.out.println(Thread.currentThread().getName()+":"+t1.get());
            System.out.println(Thread.currentThread().getName()+":"+t1.get());
            System.out.println(Thread.currentThread().getName()+":"+t1.get());
        },"蓝色").start();

        new Thread(()->{
            t1.set("紫萱");
            System.out.println(Thread.currentThread().getName()+":"+t1.get());
            System.out.println(Thread.currentThread().getName()+":"+t1.get());
            System.out.println(Thread.currentThread().getName()+":"+t1.get());
        },"紫色").start();
    }
}
