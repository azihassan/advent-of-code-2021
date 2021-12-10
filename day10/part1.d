import std;

void main()
{
    int[char] penalties = [
        ')': 3,
        ']': 57,
        '}': 1197,
        '>': 25137
    ];

    int count;
    foreach(string line; stdin.lines())
    {
        char incorrect = findIncorrect(line.strip(), 'x');
        if(incorrect != 'x')
        {
            count += penalties[incorrect];
        }
    }
    count.writeln();
}

char findIncorrect(string line, char sentinel = 'x')
{
    char[] stack;
    char[char] pairs = [
        ')': '(',
        ']': '[',
        '}': '{',
        '>': '<'
    ];
    foreach(c; line)
    {
        //writeln(c, " => ", stack);
        if(c in pairs)
        {
            if(stack.back != pairs[c])
            {
                return c;
            }
            stack.popBack();
        }
        else
        {
            stack ~= c;
        }
    }
    return sentinel;
}

unittest
{
    assert("{([(<{}[<>[]}>{[]{[(<()>".findIncorrect() == '}');
    assert("[[<[([]))<([[{}[[()]]]".findIncorrect() == ')');
    assert("[{[{({}]{}}([{[{{{}}([]".findIncorrect() == ']');
    assert("[<(<(<(<{}))><([]([]()".findIncorrect() == ')');
    assert("<{([([[(<>()){}]>(<<{{".findIncorrect() == '>');
    assert("<{([{{}}[<[[[<>{}]]]>[]]".findIncorrect('x') == 'x');
}
